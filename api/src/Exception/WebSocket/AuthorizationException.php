<?php

namespace App\Exception\WebSocket;

use App\Enum\WebSocketClientMessageTypeEnum;
use JetBrains\PhpStorm\Pure;

class AuthorizationException extends WebSocketException
{
    #[Pure]
    final public static function authorizationIsRequired(WebSocketClientMessageTypeEnum $clientMessageType): self
    {
        return new self($clientMessageType, 'auth@authRequired');
    }
}