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

    case ADD_TRACK = 'add-music';
    case UPDATE_TRACK = 'update-music';
    case DELETE_TRACK = 'delete-music';

    case CREATE_SUBSCRIPTION = 'create-subscription';
    case UPDATE_SUBSCRIPTION = 'update-subscription';
    case DELETE_SUBSCRIPTION = 'delete-subscription';

    case CREATE_LANG = 'create-language';
    case UPDATE_LANG = 'update-language';
    case DELETE_LANG = 'delete-language';

    case CREATE_TRANSLATION_KEY = 'create-translation-key';
    case UPDATE_TRANSLATION_KEY = 'update-translation-key';
    case DELETE_TRANSLATION_KEY = 'delete-translation-key';

    case CREATE_TRANSLATION = 'create-translation-to-language';
    case UPDATE_TRANSLATION = 'update-language-translation';
    case DELETE_TRANSLATION = 'delete-translation-from-language';

    /**
     * @return array
     */
    public static function getPermissionNames(): array
    {

        return [
            self::ADD_TRACK->value           => 'rolePermission@addTrack',
            self::UPDATE_TRACK->value        => 'rolePermission@updateTrack',
            self::DELETE_TRACK->value        => 'rolePermission@deleteTrack',
            self::CREATE_SUBSCRIPTION->value => 'rolePermission@createSubscription',
            self::UPDATE_SUBSCRIPTION->value => 'rolePermission@updateSubscription',
            self::DELETE_SUBSCRIPTION->value => 'rolePermission@deleteSubscription',
            self::CREATE_LANG->value         => 'rolePermission@createLang',
            self::UPDATE_LANG->value         => 'rolePermission@updateLang',
            self::DELETE_LANG->value         => 'rolePermission@deleteLang',
            self::CREATE_TRANSLATION->value  => 'rolePermission@addLangTranslation',
            self::UPDATE_TRANSLATION->value  => 'rolePermission@updateLangTranslation',
            self::DELETE_TRANSLATION->value  => 'rolePermission@deleteTranslationFromLanguage',
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