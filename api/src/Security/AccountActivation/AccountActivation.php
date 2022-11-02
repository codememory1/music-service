<?php

namespace App\Security\AccountActivation;

use App\Dto\Transfer\AccountActivationDto;
use App\Entity\AccountActivationCode;
use App\Event\AccountActivationEvent;
use App\Exception\Http\InvalidException;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

class AccountActivation extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function activate(AccountActivationDto $accountActivationDto): JsonResponse
    {
        $this->validate($accountActivationDto);

        $finedAccountActivationCode = $this->em->getRepository(AccountActivationCode::class)->findOneBy([
            'user' => $accountActivationDto->user,
            'code' => $accountActivationDto->code
        ]);

        if (null === $finedAccountActivationCode || false === $finedAccountActivationCode->isValidTtlByCreatedAt()) {
            throw InvalidException::invalidCode();
        }

        $accountActivationDto->user->setActiveStatus();

        $this->flusherService->addRemove($finedAccountActivationCode)->save();

        $this->eventDispatcher->dispatch(new AccountActivationEvent($finedAccountActivationCode));

        return $this->responseCollection->successUpdate('accountActivation@successActivate');
    }
}