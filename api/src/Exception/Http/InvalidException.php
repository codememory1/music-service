<?php

namespace App\Exception\Http;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

class InvalidException extends HttpException
{
    #[Pure]
    final public static function invalidRefreshToken(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::CHECK_VALID, 'common@invalidRefreshToken', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function invalidCode(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::CHECK_VALID, 'common@invalidCode', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function invalidSubtitles(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::CHECK_VALID, 'common@invalidSubtitles', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function invalidMultimedia(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::CHECK_VALID, 'common@invalidMultimediaFile', data: $data, headers: $headers);
    }
}