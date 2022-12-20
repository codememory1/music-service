<?php

namespace App\Event;

use App\Entity\User;

final class PreUserRegistrationEvent
{
    public function __construct(
        public readonly User $user
    ) {
    }
}