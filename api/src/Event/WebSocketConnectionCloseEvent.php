<?php

namespace App\Event;

use App\Message\WebSocketConnectionCloseMessage;

final class WebSocketConnectionCloseEvent
{
    public readonly WebSocketConnectionCloseMessage $message;

    public function __construct(WebSocketConnectionCloseMessage $message)
    {
        $this->message = $message;
    }
}