<?php

namespace App\Exception\Http;

use App\Enum\PlatformCodeEnum;
use App\Exception\HttpException;
use JetBrains\PhpStorm\Pure;

class PlaylistException extends HttpException
{
    #[Pure]
    final public static function limitExceeded(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::LIMIT, 'playlist.limit_exceeded', $parameters, $headers);
    }
}