<?php

namespace App\Event;

use App\Entity\AccountActivationCode;

final class AccountActivationEvent
{
    public readonly AccountActivationCode $accountActivationCode;

    public function __construct(AccountActivationCode $accountActivationCode)
    {
        $this->accountActivationCode = $accountActivationCode;
    }
}