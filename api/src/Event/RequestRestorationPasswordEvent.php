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
    /**
     * @var PasswordReset
     */
    public readonly PasswordReset $passwordReset;

    /**
     * @param PasswordReset $passwordReset
     */
    public function __construct(PasswordReset $passwordReset)
    {
        $this->passwordReset = $passwordReset;
    }
}