<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

final class UserRegistrationEvent extends Event
{
    public function __construct(
        public readonly User $user
    ) {
    }
}