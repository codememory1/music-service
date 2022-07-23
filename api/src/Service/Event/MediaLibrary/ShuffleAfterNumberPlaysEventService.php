<?php

namespace App\Service\Event\MediaLibrary;

use App\Service\Event\Interfaces\EventInterface;

/**
 * Class ShuffleAfterNumberPlaysEventService.
 *
 * @package App\Service\MediaLibrary
 *
 * @author  Codememory
 */
class ShuffleAfterNumberPlaysEventService implements EventInterface
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