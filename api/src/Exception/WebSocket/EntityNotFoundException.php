<?php

namespace App\Exception\WebSocket;

use App\Enum\PlatformCodeEnum;
use App\Exception\WebSocketException;
use JetBrains\PhpStorm\Pure;

class EntityNotFoundException extends WebSocketException
{
    #[Pure]
    final public static function userSession(): self
    {
        return new self(PlatformCodeEnum::ENTITY_NOT_FOUND, 'entityNotFound@userSession');
    }

    #[Pure]
    final public static function runningMultimedia(): self
    {
        return new self(PlatformCodeEnum::ENTITY_NOT_FOUND, 'entityNotFound@runningMultimedia');
    }

    #[Pure]
    final public static function streamRunningMultimedia(): self
    {
        return new self(PlatformCodeEnum::ENTITY_NOT_FOUND, 'entityNotFound@streamRunningMultimedia');
    }

    #[Pure]
    final public static function friend(): self
    {
        return new self(PlatformCodeEnum::ENTITY_NOT_FOUND, 'entityNotFound@friend');
    }
}