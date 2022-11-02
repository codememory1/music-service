<?php

namespace App\Event;

use App\Entity\AccountActivationCode;

final class AccountActivationEvent
{
    public function __construct(
        public readonly AccountActivationCode $accountActivationCode
    ) {}
}