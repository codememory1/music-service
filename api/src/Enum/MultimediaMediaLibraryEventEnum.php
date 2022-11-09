<?php

namespace App\Enum;

use App\Enum\Interfaces\EventInterface;
use App\Service\Event\MultimediaMediaLibrary\NextMultimediaAfterEndEvent;
use App\Service\Event\MultimediaMediaLibrary\RangeTimeEvent;
use App\Service\MultimediaMediaLibraryEvent\DeleteMultimediaMediaLibraryEvent;

enum MultimediaMediaLibraryEventEnum : string implements EventInterface
{
    case RANGE_TIME = 'events/multimedia-media-library/range_time';
    case NEXT_MULTIMEDIA_AFTER_END = 'events/multimedia-media-library/next_multimedia_after_end';
    case DELETE_MULTIMEDIA_AFTER_NUMBER_PLAYS = 'events/multimedia-media-library/delete_multimedia_after_number_plays';

    public function getNamespaceSchema(): ?string
    {
        return match ($this) {
            self::RANGE_TIME => RangeTimeEvent::class,
            self::NEXT_MULTIMEDIA_AFTER_END => NextMultimediaAfterEndEvent::class,
            self::DELETE_MULTIMEDIA_AFTER_NUMBER_PLAYS => DeleteMultimediaMediaLibraryEvent::class
        };
    }
}