<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class UserRegistrationEvent
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class UserRegistrationEvent extends Event
{

    /**
     * @var User
     */
    private User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {

        $this->user = $user;

    }

    /**
     * @return User
     */
    public function getUser(): User
    {

        return $this->user;

    }

}