<?php

namespace App\Enum;

/**
 * Enum MultimediaMimeTypeEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum MultimediaMimeTypeEnum
{
    /**
     * @return string[]
     */
    public static function trackMimeTypes(): array
    {
        return [
            'audio/wav',
            'audio/x-wav',
            'audio/mpeg3',
            'audio/x-mpeg-3',
            'video/mpeg',
            'video/x-mpeg',
            'audio/aac',
            'audio/ogg'
        ];
    }

    /**
     * @return string[]
     */
    public static function clipMimeTypes(): array
    {
        return [
            'video/mp4',
            'video/quicktime',
            'video/x-ms-wmv'
        ];
    }
}