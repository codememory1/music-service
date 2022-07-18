<?php

namespace App\Enum;

/**
 * Enum MultimediaMediaLibraryEventEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum MultimediaMediaLibraryEventEnum
{
    case START_ON_TIME;
    case END_ON_TIME;
    case NEXT_MULTIMEDIA_AFTER_END;
    case DELETE_MULTIMEDIA_AFTER_NUMBER_PLAYS;
}