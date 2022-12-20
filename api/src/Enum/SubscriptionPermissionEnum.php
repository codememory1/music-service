<?php

namespace App\Enum;

enum SubscriptionPermissionEnum
{
    case SHOW_MY_ALBUMS;
    case CREATE_ALBUM;
    case UPDATE_ALBUM;
    case DELETE_ALBUM;
    case ADD_MULTIMEDIA;
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
    case SHOW_MY_PLAYLIST_DIRECTORIES;
    case CREATE_DIRECTORY_TO_PLAYLIST;
    case UPDATE_DIRECTORY_TO_PLAYLIST;
    case DELETE_DIRECTORY_TO_PLAYLIST;
    case UPDATE_PROFILE_DESIGN;
    case SHOW_MY_FRIENDS;
    case ADD_AS_FRIEND;
    case DELETE_FRIEND;
    case SHARE_MULTIMEDIA_WITH_FRIENDS;
    case SHARE_MEDIA_LIBRARY_WITH_FRIENDS;
    case CONTROL_MULTIMEDIA_MEDIA_LIBRARY_EVENT;
    case CONTROL_MEDIA_LIBRARY_EVENT;
    case ADD_TIME_CODE_TO_MULTIMEDIA;
    case UPDATE_TIME_CODE_TO_MULTIMEDIA;
    case DELETE_TIME_CODE_TO_MULTIMEDIA;
    case SHOW_MULTIMEDIA_STATISTICS;
    case MAX_PLAYLISTS_IN_MEDIA_LIBRARY;
    case MAX_DIRECTORIES_IN_PLAYLIST;
    case ADD_MULTIMEDIA_FROM_EXTERNAL_SERVICE;
    case UPDATE_MULTIMEDIA_FROM_EXTERNAL_SERVICE;
    case DELETE_MULTIMEDIA_FROM_EXTERNAL_SERVICE;
    case USER_SETTING_HIDE_MY_MULTIMEDIA;
}