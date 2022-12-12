<?php

namespace App\Exception\Http;

use App\Enum\PlatformCodeEnum;
use App\Exception\HttpException;
use JetBrains\PhpStorm\Pure;

class LimitException extends HttpException
{
    #[Pure]
    final public static function playlistLimitExceeded(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::LIMIT, 'playlist.limit_exceeded', $parameters, $headers);
    }

    #[Pure]
    final public static function playlistDirectoryLimitExceeded(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::LIMIT, 'playlist.directory.limit_exceeded', $parameters, $headers);
    }
}