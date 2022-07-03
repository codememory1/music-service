<?php

namespace App\Event;

use App\Entity\AccountActivationCode;

/**
 * Class AccountActivationEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class AccountActivationEvent
{
    public readonly AccountActivationCode $accountActivationCode;

    public function __construct(AccountActivationCode $accountActivationCode)
    {
        $this->accountActivationCode = $accountActivationCode;
    }
}