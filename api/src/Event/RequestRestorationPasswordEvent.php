<?php

namespace App\Event;

use App\Entity\PasswordReset;

class RequestRestorationPasswordEvent
{
    public function __construct(
        public readonly PasswordReset $passwordReset
    ) {}
}