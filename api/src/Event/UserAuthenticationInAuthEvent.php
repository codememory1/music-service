<?php

namespace App\Event;

use App\DTO\AuthorizationDTO;
use App\Entity\User;

/**
 * Class UserAuthenticationInAuthEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class UserAuthenticationInAuthEvent
{
    public readonly AuthorizationDTO $authorizationDTO;
    public readonly User $user;

    public function __construct(AuthorizationDTO $authorizationDTO, User $user)
    {
        $this->authorizationDTO = $authorizationDTO;
        $this->user = $user;
    }
}