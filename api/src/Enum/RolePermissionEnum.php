<?php

namespace App\Enum;

/**
 * Enum RolePermissionEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum RolePermissionEnum
{
    case VIEW_LANGUAGES_WITH_FULL_INFO;
    case CREATE_LANGUAGE;
    case UPDATE_LANGUAGE;
    case DELETE_LANGUAGE;
    case CREATE_USER_ROLE;
    case UPDATE_USER_ROLE;
    case DELETE_USER_ROLE;
}