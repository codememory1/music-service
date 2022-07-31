<?php

namespace App\Event;

use App\Dto\Transfer\AuthorizationDto;
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
    public readonly AuthorizationDto $authorizationDto;
    public readonly User $user;

    public function __construct(AuthorizationDto $authorizationDto, User $user)
    {
        $this->authorizationDto = $authorizationDto;
        $this->user = $user;
    }
}