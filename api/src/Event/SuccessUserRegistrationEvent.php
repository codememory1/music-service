<?php

namespace App\Event;

use App\Entity\User;

final class SuccessUserRegistrationEvent
{
    public function __construct(
        public readonly User $user
    ) {
    }
}