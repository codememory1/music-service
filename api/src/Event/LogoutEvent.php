<?php

namespace App\Event;

use App\Entity\UserSession;

final class LogoutEvent
{
    public readonly UserSession $userSession;

    public function __construct(UserSession $userSession)
    {
        $this->userSession = $userSession;
    }
}