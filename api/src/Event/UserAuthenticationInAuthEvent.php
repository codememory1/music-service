<?php

namespace App\Event;

use App\Dto\Transfer\AuthorizationDto;
use App\Entity\User;

final class UserAuthenticationInAuthEvent
{
    public readonly AuthorizationDto $authorizationDTO;
    public readonly User $user;

    public function __construct(AuthorizationDto $authorizationDTO, User $user)
    {
        $this->authorizationDTO = $authorizationDTO;
        $this->user = $user;
    }
}