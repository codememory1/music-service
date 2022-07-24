<?php

namespace App\Security\AccountActivation;

use App\DTO\AccountActivationDTO;
use App\Entity\AccountActivationCode;
use App\Enum\EventEnum;
use App\Event\AccountActivationEvent;
use App\Rest\Http\Exceptions\InvalidException;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class AccountActivation.
 *
 * @package App\Security\AccountActivation
 *
 * @author  Codememory
 */
class AccountActivation extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function activate(AccountActivationDTO $accountActivationDTO): JsonResponse
    {
        if (false === $this->validate($accountActivationDTO)) {
            return $this->validator->getResponse();
        }

        $finedAccountActivationCode = $this->em->getRepository(AccountActivationCode::class)->findOneBy([
            'user' => $accountActivationDTO->user,
            'code' => $accountActivationDTO->code
        ]);

        if (null === $finedAccountActivationCode || false === $finedAccountActivationCode->isValidTtlByCreatedAt()) {
            throw InvalidException::invalidCode();
        }

        $accountActivationDTO->user->setActiveStatus();

        $this->em->remove($finedAccountActivationCode);
        $this->em->flush();

        $this->eventDispatcher->dispatch(
            new AccountActivationEvent($finedAccountActivationCode),
            EventEnum::ACCOUNT_ACTIVATION->value
        );

        return $this->responseCollection->successUpdate('accountActivation@successActivate');
    }
}