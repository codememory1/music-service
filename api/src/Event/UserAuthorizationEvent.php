<?php

namespace App\Event;

use App\Entity\User;
use App\Security\Auth\AuthorizationToken;

/**
 * Class UserAuthorizationEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class UserAuthorizationEvent
{
    public readonly User $authorizedUser;
    public readonly AuthorizationToken $authorizationToken;

    public function __construct(User $authorizedUser, AuthorizationToken $authorizationToken)
    {
        $this->authorizedUser = $authorizedUser;
        $this->authorizationToken = $authorizationToken;
    }
}