<?php

namespace App\Enum;

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
enum MultimediaMediaLibraryEventEnum : string
{
    case START_ON_TIME = 'events/multimedia-media-library/start_on_time';
    case END_ON_TIME = 'events/multimedia-media-library/end_on_time';
    case NEXT_MULTIMEDIA_AFTER_END = 'events/multimedia-media-library/next_multimedia_after_end';
    case DELETE_MULTIMEDIA_AFTER_NUMBER_PLAYS = 'events/multimedia-media-library/delete_multimedia_after_number_plays';
    public const SCHEME = [
        StartOnTimeEventService::class => self::START_ON_TIME,
        EndOnTimeEventService::class => self::END_ON_TIME,
        NextMultimediaAfterEndEventService::class => self::NEXT_MULTIMEDIA_AFTER_END,
        DeleteMultimediaMediaLibraryEventService::class => self::DELETE_MULTIMEDIA_AFTER_NUMBER_PLAYS
    ];

    public static function getScheme(?MultimediaMediaLibraryEventEnum $eventEnum): ?string
    {
        $scheme = [];

        foreach (self::SCHEME as $namespace => $event) {
            $scheme[$event->name] = $namespace;
        }

        return null === $eventEnum || false === array_key_exists($eventEnum->name, $scheme) ? null : $scheme[$eventEnum->name];
    }
}