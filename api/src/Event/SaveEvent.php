<?php

namespace App\Event;

use App\Service\Event\Interfaces\EventInterface;

final class SaveEvent
{
    public function __construct(
        public readonly EventInterface $event
    ) {
    }
}