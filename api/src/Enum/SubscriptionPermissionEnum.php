<?php

namespace App\Enum;

/**
 * Enum SubscriptionPermissionEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum SubscriptionPermissionEnum
{
    case SHOW_MY_ALBUMS;
    case CREATE_ALBUM;
    case UPDATE_ALBUM;
    case DELETE_ALBUM;
    case ADD_MULTIMEDIA;
    case LISTENING_TO_MULTIMEDIA;
}