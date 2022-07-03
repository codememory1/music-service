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
    public static function trackMimeTypes(): array
    {
        return [
            'audio/wav',
            'audio/x-wav',
            'audio/mpeg3',
            'audio/mpg',
            'audio/x-mpeg-3',
            'video/mpeg',
            'video/x-mpeg',
            'audio/aac',
            'audio/ogg'
        ];
    }

    public static function clipMimeTypes(): array
    {
        return [
            'video/mp4',
            'video/x-m4v',
            'video/quicktime',
            'video/x-ms-wmv'
        ];
    }
}