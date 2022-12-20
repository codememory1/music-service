<?php

namespace App\Event;

use App\Dto\Transfer\AuthorizationDto;
use App\Entity\User;

final class UserIdentificationInAuthEvent
{
    public function __construct(
        public readonly AuthorizationDto $authorizationDto,
        public readonly User $user
    ) {
    }
}