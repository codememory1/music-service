<?php

namespace App\Exception\Http;

use App\Enum\PlatformCodeEnum;
use App\Exception\HttpException;
use JetBrains\PhpStorm\Pure;

class EventException extends HttpException
{
    #[Pure]
    final public static function invalidRangeFromTime(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::TEXT_ENTRY_VALIDATION_ERROR, 'event@invalidRangeFromTime', $parameters, $headers);
    }
}