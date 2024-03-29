<?php

namespace App\Enum;

use App\Enum\Interfaces\EventInterface;
use App\Service\Event\MediaLibrary\ShareWithFriendsAfterAddEvent;
use App\Service\Event\MediaLibrary\ShuffleAfterNumberPlaysEvent;

enum MediaLibraryEventEnum : string implements EventInterface
{
    case SHARE_WITH_FRIENDS_AFTER_ADD = 'events/media-library/share_with_friends_after_adding';
    case SHUFFLE_AFTER_NUMBER_PLAYS = 'events/media-library/shuffle_after_number_plays';

    public function getNamespaceSchema(): ?string
    {
        return match ($this) {
            self::SHARE_WITH_FRIENDS_AFTER_ADD => ShareWithFriendsAfterAddEvent::class,
            self::SHUFFLE_AFTER_NUMBER_PLAYS => ShuffleAfterNumberPlaysEvent::class
        };
    }
}