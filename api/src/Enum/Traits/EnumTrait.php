<?php

namespace App\Enum\Traits;

trait EnumTrait
{
    public static function fromName(string $name): ?static
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        return null;
    }
}