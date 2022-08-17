<?php

namespace App\Event;

use App\Entity\PasswordReset;

final class RequestRestorationPasswordEvent
{
    public readonly PasswordReset $passwordReset;

    public function __construct(PasswordReset $passwordReset)
    {
        $this->passwordReset = $passwordReset;
    }
}