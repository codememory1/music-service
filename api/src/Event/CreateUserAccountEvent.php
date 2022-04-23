<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class CreateUserAccountEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class CreateUserAccountEvent extends Event
{
    /**
     * @var User
     */
    public readonly User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}