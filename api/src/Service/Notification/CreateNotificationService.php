<?php

namespace App\Service\Notification;

use App\DTO\NotificationDTO;
use App\Entity\User;
use App\Message\NotificationMessage;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class CreateNotificationService.
 *
 * @package App\Service\Notification
 *
 * @author  Codememory
 */
class CreateNotificationService extends AbstractService
{
    #[Required]
    public ?MessageBusInterface $bus = null;

    /**
     * @param NotificationDTO $notificationDTO
     * @param null|User       $from
     *
     * @return JsonResponse
     */
    public function make(NotificationDTO $notificationDTO, ?User $from): JsonResponse
    {
        if (false === $this->validate($notificationDTO)) {
            return $this->validator->getResponse();
        }

        $this->bus->dispatch(new NotificationMessage([
            'type' => $notificationDTO->type,
            'from' => $from->getId(),
            'title' => $notificationDTO->title,
            'message' => $notificationDTO->message,
            'action' => $notificationDTO->action
        ], $notificationDTO->to));

        return $this->responseCollection->successCreate('notification@successCreate');
    }
}