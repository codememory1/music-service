<?php

namespace App\Service\Notification;

use App\DTO\NotificationDTO;
use App\Entity\User;
use App\Enum\NotificationStatusEnum;
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

        $notificationEntity = $notificationDTO->getEntity();

        $notificationEntity->setStatus(NotificationStatusEnum::EXPECTS);
        $notificationEntity->setFrom($from);

        $this->em->persist($notificationEntity);
        $this->em->flush();

        return $this->responseCollection->successCreate('notification@successCreate');
    }
}