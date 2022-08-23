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

    #[Pure]
    final public static function runningMultimedia(WebSocketClientMessageTypeEnum $clientMessageType): self
    {
        return new self($clientMessageType, 'entityNotFound@runningMultimedia');
    }

    #[Pure]
    final public static function streamRunningMultimedia(WebSocketClientMessageTypeEnum $clientMessageType): self
    {
        return new self($clientMessageType, 'entityNotFound@streamRunningMultimedia');
    }
}