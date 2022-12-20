<?php

namespace App\Message;

final class WebSocketConnectionCloseMessage
{
    public function __construct(
        public readonly int $connectionId
    ) {
    }
}