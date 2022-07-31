<?php

namespace App\Service\Notification;

use App\Dto\Transfer\NotificationDto;
use App\Entity\Notification;
use App\Entity\User;
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

    public function create(NotificationDto $notificationDto, ?User $fromUser): Notification
    {
        $this->validate($notificationDto);

        $notification = $notificationDto->getEntity();

        $notification->setExpectsStatus();
        $notification->setFrom($fromUser);

        $this->flusherService->save($notification);

        return $notification;
    }

    public function request(NotificationDto $notificationDto, ?User $fromUser): JsonResponse
    {
        $this->create($notificationDto, $fromUser);

        return $this->responseCollection->successCreate('notification@successCreate');
    }
}