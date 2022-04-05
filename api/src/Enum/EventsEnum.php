<?php

namespace App\Enum;

/**
 * Enum EventsEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum EventsEnum: string
{
    case USER_REGISTRATION = 'user.registration';
    case PASSWORD_RECOVERY_REQUEST = 'password.recovery-request';
}