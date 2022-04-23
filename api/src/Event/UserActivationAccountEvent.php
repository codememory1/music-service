<?php

namespace App\Event;

use App\Entity\UserActivationToken;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class UserActivationAccountEvent
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class UserActivationAccountEvent extends Event
{
    /**
     * @var UserActivationToken
     */
    public readonly UserActivationToken $userActivationToken;

    /**
     * @param UserActivationToken $userActivationToken
     */
    public function __construct(UserActivationToken $userActivationToken)
    {
        $this->userActivationToken = $userActivationToken;
    }
}