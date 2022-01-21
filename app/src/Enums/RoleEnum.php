<?php

namespace App\Enums;

/**
 * Enum RoleEnum
 *
 * @package App\Enums
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