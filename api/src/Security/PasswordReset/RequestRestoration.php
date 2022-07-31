<?php

namespace App\Security\PasswordReset;

use App\Dto\Transfer\RequestRestorationPasswordDto;
use App\Enum\EventEnum;
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

    public function send(RequestRestorationPasswordDto $requestRestorationPasswordDto): JsonResponse
    {
        $this->validate($requestRestorationPasswordDto);

        $passwordReset = $requestRestorationPasswordDto->getEntity();

        $passwordReset->setTtl('10m');
        $passwordReset->setInProcessStatus();

        $this->eventDispatcher->dispatch(
            new RequestRestorationPasswordEvent($passwordReset),
            EventEnum::AFTER_REQUEST_RESTORATION_PASSWORD->value
        );

        $this->flusherService->save($passwordReset);

        $this->eventDispatcher->dispatch(
            new RequestRestorationPasswordEvent($passwordReset),
            EventEnum::REQUEST_RESTORATION_PASSWORD->value
        );

        return $this->responseCollection->successSendRequestRestorationPassword();
    }
}