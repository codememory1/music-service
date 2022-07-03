<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class UserRegistrationEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class UserRegistrationEvent extends Event
{
    public readonly User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}