<?php

namespace App\Exception\WebSocket;

use App\Enum\WebSocketClientMessageTypeEnum;
use JetBrains\PhpStorm\Pure;

class EntityNotFoundException extends WebSocketException
{
    #[Pure]
    final public static function userSession(WebSocketClientMessageTypeEnum $clientMessageType): self
    {
        return new self($clientMessageType, 'entityNotFound@userSession');
    }
}