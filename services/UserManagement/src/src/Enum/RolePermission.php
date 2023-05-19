<?php

namespace App\Enum;

enum RolePermission: string
{
    case FETCH_ALL_ACCESS_KEY = 'role_permission.fetch_all_access_key';
    case CREATE_ACCESS_KEY = 'role_permission.create_access_key';
    case UPDATE_ACCESS_KEY = 'role_permission.update_access_key';
    case DELETE_ACCESS_KEY = 'role_permission.delete_access_key';
}