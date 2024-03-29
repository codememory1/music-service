<?php

namespace App\Service\Event\MultimediaMediaLibrary;

use App\Service\Event\Interfaces\EventInterface;

final class DeleteMultimediaAfterNumberPlaysEvent implements EventInterface
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function getNumber(): int
    {
        return $this->payload['number'];
    }

    public function toArray(): array
    {
        return $this->toArray();
    }
}