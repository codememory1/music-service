<?php

namespace App\Enums;

/**
 * Enum StatusEnum
 *
 * @package App\Enums
 *
 * @author  Codememory
 */
enum StatusEnum: int
{

    case NOT_ACTIVE = 0;
    case ACTIVE = 1;
    case BLOCKED = 2;
    case HIDDEN = 3;

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