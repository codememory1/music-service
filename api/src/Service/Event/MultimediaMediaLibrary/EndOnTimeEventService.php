<?php

namespace App\Service\Event\MultimediaMediaLibrary;

use App\Service\Event\Interfaces\EventInterface;

/**
 * Class EndOnTimeEventService.
 *
 * @package App\Service\Event\MultimediaMediaLibrary
 *
 * @author  Codememory
 */
class EndOnTimeEventService implements EventInterface
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function getOnTime(): int|float
    {
        return $this->payload['on_time'];
    }

    public function toArray(): array
    {
        return $this->toArray();
    }
}