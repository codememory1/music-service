<?php

namespace App\Enum;

/**
 * Enum RoleEnum
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum RoleEnum: string
{

    case USER = 'user';
    case DEVELOPER = 'developer';
    case ADMIN = 'administrator';
    case MUSIC_MANAGER = 'music-manager';
    case SUPPORT = 'support';

}