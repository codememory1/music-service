<?php

namespace App\Event;

use App\DTO\AuthorizationDTO;
use App\Entity\User;

/**
 * Class userIdentificationInAuthEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class UserIdentificationInAuthEvent
{
    public readonly AuthorizationDTO $authorizationDTO;
    public readonly User $user;

    public function __construct(AuthorizationDTO $authorizationDTO, User $user)
    {
        $this->authorizationDTO = $authorizationDTO;
        $this->user = $user;
    }
}