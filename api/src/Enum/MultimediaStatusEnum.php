<?php

namespace App\Enum;

/**
 * Enum MultimediaStatusEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum MultimediaStatusEnum: string
{
    case DRAFT = 'status@draft';
    case MODERATION = 'status@moderation';
    case PUBLISHED = 'status@published';
    case UNPUBLISHED = 'status@unpublished';
    case APPEAL = 'status@appeal';
    case APPEAL_CANCELED = 'status@appealCanceled';

    /**
     * @param string $value
     *
     * @return null|string
     */
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