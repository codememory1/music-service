<?php

namespace App\Event;

use App\Entity\User;
use App\Security\Auth\AuthorizationToken;

final class UserAuthorizationEvent
{
    public function __construct(
        public readonly User $authorizedUser,
        public readonly AuthorizationToken $authorizationToken
    ) {}
}