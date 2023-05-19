<?php

namespace App\Enum;

enum MultimediaStatusEnum: string
{
    case DRAFT = 'status.draft';
    case MODERATION = 'status.moderation';
    case PUBLISHED = 'status.published';
    case UNPUBLISHED = 'status.unpublished';
    case APPEAL = 'status.appeal';
    case APPEAL_CANCELED = 'status.appeal_canceled';

    public static function getValueByName(string $value): ?string
    {
        foreach (self::cases() as $case) {
            if ($case->name === $value) {
                return $case->value;
            }
        }

        return null;
    }
}