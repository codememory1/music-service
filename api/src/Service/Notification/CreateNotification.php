<?php

namespace App\Service\Notification;

use App\Dto\Transfer\NotificationDto;
use App\Entity\Notification;
use App\Entity\User;
use App\Infrastructure\Validator\Validator;
use App\Service\FlusherService;

class CreateNotification
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly Validator $validator
    ) {
    }

    public function create(NotificationDto $dto, ?User $from): Notification
    {
        $this->validator->validate($dto);

        $notification = $dto->getEntity();

        $notification->setExpectsStatus();
        $notification->setFrom($from);

        $this->flusher->save($notification);

        return $notification;
    }
}