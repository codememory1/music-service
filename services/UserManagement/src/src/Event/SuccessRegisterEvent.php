<?php

namespace App\Event;

use App\Entity\User;

final class SuccessRegisterEvent
{
    public function __construct(
        public readonly User $user
    ) {
    }
}