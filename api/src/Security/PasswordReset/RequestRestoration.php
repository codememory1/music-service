<?php

namespace App\Security\PasswordReset;

use App\DTO\RequestRestorationPasswordDTO;
use App\Enum\EventEnum;
use App\Enum\PasswordResetStatusEnum;
use App\Event\RequestRestorationPasswordEvent;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class RequestRestoration.
 *
 * @package App\Security\PasswordReset
 *
 * @author  Codememory
 */
class RequestRestoration extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function send(RequestRestorationPasswordDTO $requestRestorationPasswordDTO): JsonResponse
    {
        if (false === $this->validate($requestRestorationPasswordDTO)) {
            return $this->validator->getResponse();
        }

        $passwordResetEntity = $requestRestorationPasswordDTO->getEntity();

        $passwordResetEntity->setTtl('10m');
        $passwordResetEntity->setStatus(PasswordResetStatusEnum::IN_PROCESS);

        $this->em->persist($passwordResetEntity);
        $this->em->flush();

        $this->eventDispatcher->dispatch(
            new RequestRestorationPasswordEvent($passwordResetEntity),
            EventEnum::REQUEST_RESTORATION_PASSWORD->value
        );

        return $this->responseCollection->successSendRequestRestorationPassword();
    }
}