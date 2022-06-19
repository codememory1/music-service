<?php

namespace App\Enum;

/**
 * Enum MultimediaStatusEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum MultimediaStatusEnum
{
    case DRAFT;
    case MODERATION;
    case PUBLISHED;
    case REMOVED_FROM_PUBLICATION;
    case APPEAL;
}