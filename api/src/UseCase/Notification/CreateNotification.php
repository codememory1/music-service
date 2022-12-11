<?php

namespace App\UseCase\Notification;

use App\Dto\Transfer\NotificationDto;
use App\Entity\Notification;
use App\Entity\User;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;

final class CreateNotification
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator
    ) {
    }

    public function process(NotificationDto $dto, ?User $from): Notification
    {
        $this->validator->validate($dto);

        $notification = $dto->getEntity();

        $notification->setExpectsStatus();
        $notification->setFrom($from);

        $this->flusher->save($notification);

        return $notification;
    }
}