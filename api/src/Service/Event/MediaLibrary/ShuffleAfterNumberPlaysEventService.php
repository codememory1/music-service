<?php

namespace App\Service\MediaLibrary;

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

    public function isLike(): bool
    {
        return $this->payload['if_like'] ?? false;
    }

    public function isDislike(): bool
    {
        return $this->payload['is_dislike'] ?? false;
    }

    public function toArray(): array
    {
        return $this->toArray();
    }
}