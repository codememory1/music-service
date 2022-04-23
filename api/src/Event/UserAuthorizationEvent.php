<?php

namespace App\Event;

use App\Entity\User;
use App\Interfaces\AuthorizationTokenInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class UserAuthorizationEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class UserAuthorizationEvent extends Event
{
    /**
     * @var User
     */
    public readonly User $user;

    /**
     * @var AuthorizationTokenInterface
     */
    public readonly AuthorizationTokenInterface $authorizationToken;

    /**
     * @param User                        $user
     * @param AuthorizationTokenInterface $authorizationToken
     */
    public function __construct(User $user, AuthorizationTokenInterface $authorizationToken)
    {
        $this->user = $user;
        $this->authorizationToken = $authorizationToken;
    }
}