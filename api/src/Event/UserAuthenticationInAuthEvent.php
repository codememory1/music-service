<?php

namespace App\Event;

use App\Dto\Transfer\AuthorizationDto;
use App\Entity\User;

final class UserAuthenticationInAuthEvent
{
    public function __construct(
        public readonly AuthorizationDto $authorizationDTO,
        public readonly User $user
    ) {
    }
}