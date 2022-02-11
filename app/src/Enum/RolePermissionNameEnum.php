<?php

namespace App\Enum;

/**
 * Enum RolePermissionNameEnum
 *
 * @package App\Enum
 *
 * @author  codememory
 */
enum RolePermissionNameEnum: string
{

    case CREATE_LANG = 'create-lang';
    case UPDATE_LANG = 'update-lang';
    case DELETE_LANG = 'delete-lang';

    case CREATE_SUBSCRIPTION = 'create-subscription';
    case UPDATE_SUBSCRIPTION = 'update-subscription';
    case DELETE_SUBSCRIPTION = 'delete-subscription';

}