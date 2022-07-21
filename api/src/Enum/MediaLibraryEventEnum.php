<?php

namespace App\Enum;

use App\Service\Event\MediaLibrary\ShareWithFriendsAfterAddEventService;
use App\Service\Event\MediaLibrary\ShuffleAfterNumberPlaysEventService;

/**
 * Enum MediaLibraryEventEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum MediaLibraryEventEnum : string
{
    case SHARE_WITH_FRIENDS_AFTER_ADD = 'events/media-library/share_with_friends_after_adding';
    case SHUFFLE_AFTER_NUMBER_PLAYS = 'events/media-library/shuffle_after_number_plays';
    public const SCHEME = [
        ShareWithFriendsAfterAddEventService::class => self::SHARE_WITH_FRIENDS_AFTER_ADD,
        ShuffleAfterNumberPlaysEventService::class => self::SHUFFLE_AFTER_NUMBER_PLAYS
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