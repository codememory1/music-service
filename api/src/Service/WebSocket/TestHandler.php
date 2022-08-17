<?php

namespace App\Service\WebSocket;

use App\Enum\WebSocketClientMessageTypeEnum;
use App\Exception\WebSocket\EntityNotFoundException;

class TestHandler extends AbstractUserMessageHandlerService
{
    public function handler(): void
    {
        echo 12;

        throw EntityNotFoundException::userSession(WebSocketClientMessageTypeEnum::TEST);
    }
}