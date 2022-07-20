<?php

namespace App\Enum;

/**
 * Enum MultimediaMediaLibraryEventEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum MultimediaMediaLibraryEventEnum: string
{
    case START_ON_TIME = 'events/start_on_time';
    case END_ON_TIME = 'events/end_on_time';
    case NEXT_MULTIMEDIA_AFTER_END = 'events/next_multimedia_after_end';
    case DELETE_MULTIMEDIA_AFTER_NUMBER_PLAYS = 'events/delete_multimedia_after_number_plays';
}