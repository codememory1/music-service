<?php

namespace App\Event;

use App\Entity\PasswordReset;
use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class PasswordRecoveryRequestEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class PasswordRecoveryRequestEvent extends Event
{
    /**
     * @var User
     */
    public readonly User $user;

    /**
     * @var PasswordReset
     */
    public readonly PasswordReset $passwordReset;

    /**
     * @param User          $user
     * @param PasswordReset $passwordReset
     */
    public function __construct(User $user, PasswordReset $passwordReset)
    {
        $this->user = $user;
        $this->passwordReset = $passwordReset;
    }
}