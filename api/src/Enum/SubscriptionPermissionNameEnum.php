<?php

namespace App\Enum;

/**
 * Enum SubscriptionPermissionNameEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum SubscriptionPermissionNameEnum: string
{
    case CREATE_ALBUM = 'create-album';
    case UPDATE_ALBUM = 'update-album';
    case DELETE_ALBUM = 'delete-album';
    case ADD_MUSIC_TO_MEDIA_LIBRARY = 'add-music-to-media-library';
    case DELETE_MUSIC_FROM_MEDIA_LIBRARY = 'remove-music-from-media-library';
    case CREATE_PLAYLIST = 'create-playlist';
    case UPDATE_PLAYLIST = 'update-playlist';
    case DELETE_PLAYLIST = 'delete-playlist';
    case CREATE_DIRECTORY_TO_PLAYLIST = 'create-directory-to-playlist';
    case UPDATE_DIRECTORY_TO_PLAYLIST = 'update-directory-to-playlist';
    case DELETE_DIRECTORY_TO_PLAYLIST = 'delete-directory-to-playlist';
    case EVENT_MEDIA_LIBRARY_CONTROL = 'event-media-library-control';
    case EVENT_PLAYLIST_CONTROL = 'event-playlist-control';
    case EVENT_MUSIC_CONTROL = 'event-music-control';
}