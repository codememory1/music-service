<?php

namespace App\Enum;

/**
 * Enum RolePermissionNameEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum RolePermissionNameEnum: string
{
    case SHOW_ALBUMS = 'show-albums';
    case SHOW_ALBUMS_AT_OTHER_USERS = 'show-albums-at-other-users';
    case CREATE_ALBUM = 'create-album';
    case CREATE_ALBUM_AT_OTHER_USERS = 'create-album-at-other-users';
    case UPDATE_ALBUM = 'update-album';
    case UPDATE_ALBUM_AT_OTHER_USERS = 'update-album-at-other-users';
    case DELETE_ALBUM = 'delete-album';
    case DELETE_ALBUM_AT_OTHER_USERS = 'delete-album-at-other-users';
    case SHOW_ALBUM_CATEGORIES = 'show-album-categories';
    case CREATE_ALBUM_CATEGORY = 'create-album-category';
    case UPDATE_ALBUM_CATEGORY = 'update-album-category';
    case DELETE_ALBUM_CATEGORY = 'delete-album-category';
    case SHOW_ALBUM_TYPES = 'show-album-types';
    case CREATE_ALBUM_TYPE = 'create-album-type';
    case UPDATE_ALBUM_TYPE = 'update-album-type';
    case DELETE_ALBUM_TYPE = 'delete-album-type';
    case SHOW_MUSICS = 'show-musics';
    case SHOW_MUSICS_AT_OTHER_USERS = 'show-musics-at-other-users';
    case ADD_MUSIC = 'add-music';
    case ADD_MUSIC_AT_OTHER_USERS = 'add-music-at-other-users';
    case UPDATE_MUSIC = 'update-music';
    case UPDATE_MUSIC_AT_OTHER_USERS = 'update-music-at-other-users';
    case DELETE_MUSIC = 'delete-music';
    case DELETE_MUSIC_AT_OTHER_USERS = 'delete-music-at-other-users';
    case CREATE_SUBSCRIPTION = 'create-subscription';
    case UPDATE_SUBSCRIPTION = 'update-subscription';
    case DELETE_SUBSCRIPTION = 'delete-subscription';
    case SHOW_SUBSCRIPTION_PERMISSIONS = 'show-subscription-permissions';
    case CREATE_SUBSCRIPTION_PERMISSION = 'create-subscription-permission';
    case UPDATE_SUBSCRIPTION_PERMISSION = 'update-subscription-permission';
    case DELETE_SUBSCRIPTION_PERMISSION = 'delete-subscription-permission';
    case SHOW_SUBSCRIPTION_PERMISSION_NAMES = 'show-subscription-permission-names';
    case CREATE_SUBSCRIPTION_PERMISSION_NAME = 'create-subscription-permission-name';
    case UPDATE_SUBSCRIPTION_PERMISSION_NAME = 'update-subscription-permission-name';
    case DELETE_SUBSCRIPTION_PERMISSION_NAME = 'delete-subscription-permission-name';
    case CREATE_LANG = 'create-language';
    case UPDATE_LANG = 'update-language';
    case DELETE_LANG = 'delete-language';
    case CREATE_TRANSLATION = 'create-translation-to-language';
    case UPDATE_TRANSLATION = 'update-language-translation';
    case DELETE_TRANSLATION = 'delete-translation-from-language';
    case SHOW_TRANSLATION_KEYS = 'show-translation-keys';
    case CREATE_TRANSLATION_KEY = 'create-translation-key';
    case UPDATE_TRANSLATION_KEY = 'update-translation-key';
    case DELETE_TRANSLATION_KEY = 'delete-translation-key';

    /**
     * @return array
     */
    public static function getPermissionNames(): array
    {
        return [
            self::SHOW_ALBUMS->value => 'rolePermission@showAlbums',
            self::SHOW_ALBUMS_AT_OTHER_USERS->value => 'rolePermission@showAlbumsAtOtherUsers',
            self::CREATE_ALBUM->value => 'rolePermission@createAlbum',
            self::CREATE_ALBUM_AT_OTHER_USERS->value => 'rolePermission@createAlbumAtOtherUsers',
            self::UPDATE_ALBUM->value => 'rolePermission@updateAlbum',
            self::UPDATE_ALBUM_AT_OTHER_USERS->value => 'rolePermission@updateAlbumAtOtherUsers',
            self::DELETE_ALBUM->value => 'rolePermission@deleteAlbum',
            self::DELETE_ALBUM_AT_OTHER_USERS->value => 'rolePermission@deleteAlbumAtOtherUsers',

            self::SHOW_ALBUM_CATEGORIES->value => 'rolePermission@showAlbumCategories',
            self::CREATE_ALBUM_CATEGORY->value => 'rolePermission@createAlbumCategory',
            self::UPDATE_ALBUM_CATEGORY->value => 'rolePermission@updateAlbumCategory',
            self::DELETE_ALBUM_CATEGORY->value => 'rolePermission@deleteAlbumCategory',

            self::CREATE_ALBUM_TYPE->value => 'rolePermission@createAlbumType',
            self::UPDATE_ALBUM_TYPE->value => 'rolePermission@updateAlbumType',
            self::DELETE_ALBUM_TYPE->value => 'rolePermission@deleteAlbumType',

            self::SHOW_MUSICS->value => 'rolePermission@showMuscis',
            self::SHOW_MUSICS_AT_OTHER_USERS->value => 'rolePermission@showMuscisAtOtherUsers',
            self::ADD_MUSIC->value => 'rolePermission@addMusic',
            self::ADD_MUSIC_AT_OTHER_USERS->value => 'rolePermission@addMusicAtOtherUsers',
            self::UPDATE_MUSIC->value => 'rolePermission@updateMusic',
            self::UPDATE_MUSIC_AT_OTHER_USERS->value => 'rolePermission@updateMusicAtOtherUsers',
            self::DELETE_MUSIC->value => 'rolePermission@deleteMusic',
            self::DELETE_MUSIC_AT_OTHER_USERS->value => 'rolePermission@deleteMusicAtOtherUsers',

            self::CREATE_SUBSCRIPTION->value => 'rolePermission@createSubscription',
            self::UPDATE_SUBSCRIPTION->value => 'rolePermission@updateSubscription',
            self::DELETE_SUBSCRIPTION->value => 'rolePermission@deleteSubscription',

            self::SHOW_SUBSCRIPTION_PERMISSIONS->value => 'rolePermission@showSubscriptionPermissions',
            self::CREATE_SUBSCRIPTION_PERMISSION->value => 'rolePermission@createSubscriptionPermission',
            self::UPDATE_SUBSCRIPTION_PERMISSION->value => 'rolePermission@updateSubscriptionPermission',
            self::DELETE_SUBSCRIPTION_PERMISSION->value => 'rolePermission@deleteSubscriptionPermission',

            self::CREATE_LANG->value => 'rolePermission@createLang',
            self::UPDATE_LANG->value => 'rolePermission@updateLang',
            self::DELETE_LANG->value => 'rolePermission@deleteLang',

            self::SHOW_TRANSLATION_KEYS->value => 'rolePermission@showTranslationKeys',
            self::CREATE_TRANSLATION->value => 'rolePermission@createLangTranslation',
            self::UPDATE_TRANSLATION->value => 'rolePermission@updateLangTranslation',
            self::DELETE_TRANSLATION->value => 'rolePermission@deleteTranslationFromLanguage'
        ];
    }

    /**
     * @return array
     */
    public static function values(): array
    {
        $values = [];

        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}