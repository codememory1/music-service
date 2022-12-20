<?php

namespace App\Event;

use App\Entity\UserSession;

final class LogoutEvent
{
    public function __construct(
        public readonly UserSession $userSession
    ) {
    }
}