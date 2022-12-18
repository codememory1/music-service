<?php

namespace App\Enum;

enum MultimediaExternalServiceEnum: string
{
    case YOUTUBE = 'multimedia_external_services/youtube';

    public static function fromName(string $name): ?string
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case->value;
            }
        }

        return null;
    }
}
