<?php

namespace App\Event;

use App\Entity\User;

final class SuccessAuthEvent
{
    public function __construct(
        public readonly User $user
    ) {
    }
}