<?php

namespace App\Event;

use App\Entity\PasswordReset;

/**
 * Class RequestRestorationPasswordEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class RequestRestorationPasswordEvent
{
    public readonly PasswordReset $passwordReset;

    public function __construct(PasswordReset $passwordReset)
    {
        $this->passwordReset = $passwordReset;
    }
}