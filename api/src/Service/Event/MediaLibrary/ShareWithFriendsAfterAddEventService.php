<?php

namespace App\Service\Event\MediaLibrary;

use App\Service\Event\Interfaces\EventInterface;

class ShareWithFriendsAfterAddEventService implements EventInterface
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function getWithAllFriends(): bool
    {
        return $this->payload['with_all_friends'] ?? false;
    }

    public function getWithSelectedFriends(): array
    {
        return $this->payload['with_selected_friends'] ?? [];
    }

    public function toArray(): array
    {
        return $this->toArray();
    }
}