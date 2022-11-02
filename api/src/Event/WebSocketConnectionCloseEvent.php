<?php

namespace App\Event;

use App\Message\WebSocketConnectionCloseMessage;

final class WebSocketConnectionCloseEvent
{
    public function __construct(
        public readonly WebSocketConnectionCloseMessage $message
    ) {}
}