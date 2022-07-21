<?php

namespace App\Service\Event\MultimediaMediaLibrary;

use App\Service\Event\Interfaces\EventInterface;

/**
 * Class StartOnTimeEventService.
 *
 * @package App\Service\Event\MultimediaMediaLibrary
 *
 * @author  Codememory
 */
class StartOnTimeEventService implements EventInterface
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function getFromTime(): int|float
    {
        return $this->payload['from_time'];
    }

    public function toArray(): array
    {
        return $this->toArray();
    }
}