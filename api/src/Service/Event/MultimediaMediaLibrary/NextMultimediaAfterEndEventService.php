<?php

namespace App\Service\Event\MultimediaMediaLibrary;

use App\Service\Event\Interfaces\EventInterface;

class NextMultimediaAfterEndEventService implements EventInterface
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function getMultimediaId(): int
    {
        return $this->payload['multimedia_id'];
    }

    public function toArray(): array
    {
        return $this->toArray();
    }
}