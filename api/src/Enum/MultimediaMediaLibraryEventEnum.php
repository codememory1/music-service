<?php

namespace App\Enum;

use App\Enum\Interfaces\EventInterface;
use App\Service\Event\MultimediaMediaLibrary\EndOnTimeEventService;
use App\Service\Event\MultimediaMediaLibrary\NextMultimediaAfterEndEventService;
use App\Service\Event\MultimediaMediaLibrary\StartOnTimeEventService;
use App\Service\MultimediaMediaLibraryEvent\DeleteMultimediaMediaLibraryEventService;

/**
 * Enum MultimediaMediaLibraryEventEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum MultimediaMediaLibraryEventEnum : string implements EventInterface
{
    case START_ON_TIME = 'events/multimedia-media-library/start_on_time';
    case END_ON_TIME = 'events/multimedia-media-library/end_on_time';
    case NEXT_MULTIMEDIA_AFTER_END = 'events/multimedia-media-library/next_multimedia_after_end';
    case DELETE_MULTIMEDIA_AFTER_NUMBER_PLAYS = 'events/multimedia-media-library/delete_multimedia_after_number_plays';

    public function getNamespaceSchema(): ?string
    {
        return match ($this) {
            self::START_ON_TIME => StartOnTimeEventService::class,
            self::END_ON_TIME => EndOnTimeEventService::class,
            self::NEXT_MULTIMEDIA_AFTER_END => NextMultimediaAfterEndEventService::class,
            self::DELETE_MULTIMEDIA_AFTER_NUMBER_PLAYS => DeleteMultimediaMediaLibraryEventService::class
        };
    }
}