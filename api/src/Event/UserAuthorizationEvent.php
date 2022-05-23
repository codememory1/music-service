<?php

namespace App\Event;

use App\Entity\User;
use App\Security\Auth\AuthorizationToken;

/**
 * Class UserAuthorizationEvent
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class UserAuthorizationEvent
{
    /**
     * @var User
     */
    public readonly User $authorizedUser;

    /**
     * @var AuthorizationToken
     */
    public readonly AuthorizationToken $authorizationToken;

    /**
     * @param User               $authorizedUser
     * @param AuthorizationToken $authorizationToken
     */
    public function __construct(User $authorizedUser, AuthorizationToken $authorizationToken)
    {
        $this->authorizedUser = $authorizedUser;
        $this->authorizationToken = $authorizationToken;
    }
}