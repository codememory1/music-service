<?php

namespace App\Service\Event\MultimediaMediaLibrary;

use App\Service\Event\Interfaces\EventInterface;

final class RangeTimeEvent implements EventInterface
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function getFromTime(): null|int|float
    {
        return $this->payload['from_time'] ?? null;
    }

    public function getToTime(): null|int|float
    {
        return $this->payload['to_time'] ?? null;
    }

    public function toArray(): array
    {
        return $this->toArray();
    }
}