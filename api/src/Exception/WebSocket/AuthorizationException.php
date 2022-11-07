<?php

namespace App\Exception\WebSocket;

use App\Enum\PlatformCodeEnum;
use App\Exception\WebSocketException;
use JetBrains\PhpStorm\Pure;

class AuthorizationException extends WebSocketException
{
    #[Pure]
    final public static function authorizationIsRequired(): self
    {
        return new self(PlatformCodeEnum::AUTHORIZATION_REQUIRED, 'auth@authRequired');
    }
}