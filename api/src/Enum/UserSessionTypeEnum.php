<?php

namespace App\Enum;

/**
 * Enum UserSessionTypeEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum UserSessionTypeEnum: string
{
    case TEMPORARY = 'temp';
    case REGISTRATION_SESSION = 'registration_session';
}