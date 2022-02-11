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

    public const ADD_TRACK = 'add-music';
    public const UPDATE_TRACK = 'update-music';
    public const DELETE_TRACK = 'delete-music';

    public const CREATE_SUBSCRIPTION = 'create-subscription';
    public const UPDATE_SUBSCRIPTION = 'update-subscription';
    public const DELETE_SUBSCRIPTION = 'delete-subscription';

    public const CREATE_LANG = 'create-language';
    public const UPDATE_LANG = 'update-language';
    public const DELETE_LANG = 'delete-language';

    public const CREATE_TRANSLATION_KEY = 'create-translation-key';
    public const UPDATE_TRANSLATION_KEY = 'update-translation-key';
    public const DELETE_TRANSLATION_KEY = 'delete-translation-key';

    public const CREATE_TRANSLATION = 'create-translation-to-language';
    public const UPDATE_TRANSLATION = 'update-language-translation';
    public const DELETE_TRANSLATION = 'delete-translation-from-language';

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