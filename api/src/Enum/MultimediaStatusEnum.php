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
    case MODERATION;
    case PUBLISHED;
    case REMOVED_FROM_PUBLICATION;
    case HIDDEN_IN_PROFILE;
}