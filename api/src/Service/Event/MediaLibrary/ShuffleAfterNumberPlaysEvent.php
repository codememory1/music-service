<?php

namespace App\Service\Event\MediaLibrary;

use App\Service\Event\Interfaces\EventInterface;

class ShuffleAfterNumberPlaysEvent implements EventInterface
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function numbers(): int
    {
        return $this->payload['numbers'];
    }

    public function toArray(): array
    {
        return $this->toArray();
    }
}