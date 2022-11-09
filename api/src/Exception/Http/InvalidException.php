<?php

namespace App\Exception\Http;

use App\Enum\PlatformCodeEnum;
use App\Exception\HttpException;
use JetBrains\PhpStorm\Pure;

class InvalidException extends HttpException
{
    #[Pure]
    final public static function invalidCode(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::TEXT_ENTRY_VALIDATION_ERROR, 'common@invalidCode', $parameters, $headers);
    }

    #[Pure]
    final public static function invalidSubtitles(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::INVALID_DATA_FORMAT_IN_FILE, 'common@invalidSubtitles', $parameters, $headers);
    }

    #[Pure]
    final public static function invalidMultimedia(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::INVALID_DATA_FORMAT_IN_FILE, 'common@invalidMultimediaFile', $parameters, $headers);
    }
}