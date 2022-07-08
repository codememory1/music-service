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
    case SHOW_MY_MULTIMEDIA;
    case ADD_MULTIMEDIA;
    case UPDATE_MULTIMEDIA;
    case DELETE_MULTIMEDIA;
    case LISTENING_TO_MULTIMEDIA;
    case CONTROL_SUBSCRIPTION_ON_ARTIST;
    case ACCEPTING_SUBSCRIBERS;
    case ADD_MULTIMEDIA_TO_MEDIA_LIBRARY;
    case UPDATE_MULTIMEDIA_TO_MEDIA_LIBRARY;
    case DELETE_MULTIMEDIA_TO_MEDIA_LIBRARY;
    case SHOW_MY_PLAYLISTS;
    case CREATE_PLAYLIST;
    case UPDATE_PLAYLIST;
    case DELETE_PLAYLIST;
}