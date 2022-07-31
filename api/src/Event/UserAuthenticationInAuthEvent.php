<?php

namespace App\Event;

use App\Dto\Transfer\AuthorizationDto;
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
    public readonly AuthorizationDto $authorizationDTO;
    public readonly User $user;

    public function __construct(AuthorizationDto $authorizationDTO, User $user)
    {
        $this->authorizationDTO = $authorizationDTO;
        $this->user = $user;
    }
}