<?php

namespace App\Message;

final class WebSocketConnectionCloseMessage
{
    public readonly int $connectionId;

    public function __construct(int $connectionId)
    {
        $this->connectionId = $connectionId;
    }
}