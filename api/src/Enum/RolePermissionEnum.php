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
    case SHOW_ROLES;
    case CREATE_USER_ROLE;
    case UPDATE_USER_ROLE;
    case DELETE_USER_ROLE;
    case UPDATE_PERMISSIONS_TO_ROLE;
    case SHOW_FULL_INFO_SUBSCRIPTIONS;
    case CREATE_SUBSCRIPTION;
    case UPDATE_SUBSCRIPTION;
    case DELETE_SUBSCRIPTION;
    case SHOW_FULL_INFO_TRANSLATIONS;
    case CREATE_TRANSLATION;
    case UPDATE_TRANSLATION;
    case DELETE_TRANSLATION;
    case SHOW_FULL_INFO_ALBUM_TYPES;
    case CREATE_ALBUM_TYPE;
    case UPDATE_ALBUM_TYPE;
    case DELETE_ALBUM_TYPE;
    case SHOW_FULL_INFO_ALBUMS;
    case CREATE_ALBUM_TO_USER;
    case UPDATE_ALBUM_TO_USER;
    case DELETE_ALBUM_TO_USER;
    case DELETE_USER_SESSION_TO_USER;
}