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
    /**
     * @var AuthorizationDTO
     */
    public readonly AuthorizationDTO $authorizationDTO;

    /**
     * @var User
     */
    public readonly User $user;

    /**
     * @param AuthorizationDTO $authorizationDTO
     * @param User             $user
     */
    public function __construct(AuthorizationDTO $authorizationDTO, User $user)
    {
        $this->authorizationDTO = $authorizationDTO;
        $this->user = $user;
    }
}