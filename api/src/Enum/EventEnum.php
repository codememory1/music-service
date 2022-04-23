<?php

namespace App\Enum;

/**
 * Enum EventEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum EventEnum: string
{
    case USER_REGISTRATION = 'user.registration';
    case USER_AUTHORIZATION = 'user.authorization';
    case USER_PASSWORD_CHANGE = 'user.password.change';
    case USER_CREATE_ACCOUNT = 'user.account.create';
    case USER_ACTIVATION_ACCOUNT = 'user.account.activation';
    case PASSWORD_RECOVERY_REQUEST = 'user.password.recovery-request';
}