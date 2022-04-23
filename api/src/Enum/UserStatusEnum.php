<?php

namespace App\Enum;

/**
 * Enum UserStatusEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum UserStatusEnum: int
{
    case NOT_ACTIVE = 0;
    case ACTIVE = 1;
    case BLOCKED = 2;

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