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
    public static function values(): array
    {

        $values = [];

        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;

    }

}