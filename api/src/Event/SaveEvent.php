<?php

namespace App\Event;

use App\Service\Event\Interfaces\EventInterface;

final class SaveEvent
{
    public readonly EventInterface $event;

    public function __construct(EventInterface $event)
    {
        $this->event = $event;
    }
}