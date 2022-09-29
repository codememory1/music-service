<?php

namespace App\Enum;

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
    case SHOW_INFO_ABOUT_USER_SESSION;
    case SHOW_USER_SESSIONS;
    case SHOW_USER_SESSION_TOKEN_TO_USER;
    case CREATE_NOTIFICATION;
    case SHOW_FULL_INFO_MULTIMEDIA_CATEGORIES;
    case SHOW_ALL_USER_MULTIMEDIA;
    case CREATE_MULTIMEDIA_CATEGORY;
    case UPDATE_MULTIMEDIA_CATEGORY;
    case DELETE_MULTIMEDIA_CATEGORY;
    case MULTIMEDIA_STATUS_CONTROL_TO_USER;
    case ADD_MULTIMEDIA_TO_USER;
    case UPDATE_MULTIMEDIA_TO_USER;
    case DELETE_MULTIMEDIA_TO_USER;
    case ALBUM_STATUS_CONTROL_TO_USER;
    case CREATE_MEDIA_LIBRARY_TO_USER;
    case UPDATE_MEDIA_LIBRARY_TO_USER;
    case SHOW_MEDIA_LIBRARY_TO_USER;
    case DELETE_MULTIMEDIA_MEDIA_LIBRARY_TO_USER;
    case UPDATE_MULTIMEDIA_MEDIA_LIBRARY_TO_USER;
    case SHOW_FULL_INFO_USER_PLAYLISTS;
    case SHOW_USER_PLAYLISTS;
    case CREATE_PLAYLIST_TO_USER;
    case UPDATE_PLAYLIST_TO_USER;
    case DELETE_PLAYLIST_TO_USER;
    case SHOW_PLAYLIST_DIRECTORIES_TO_USER;
    case SHOW_FULL_INFO_PLAYLIST_DIRECTORIES_TO_USER;
    case CREATE_PLAYLIST_DIRECTORY_TO_USER;
    case UPDATE_PLAYLIST_DIRECTORY_TO_USER;
    case DELETE_PLAYLIST_DIRECTORY_TO_USER;
    case ADD_MULTIMEDIA_TO_PLAYLIST_DIRECTORY;
    case DELETE_MULTIMEDIA_TO_PLAYLIST_DIRECTORY;
    case UPDATE_USER_PROFILE_DESIGN;
    case ADD_FRIEND_TO_USER;
    case DELETE_FRIEND_TO_USER;
    case SHOW_MULTIMEDIA_STATISTICS_TO_USER;
}