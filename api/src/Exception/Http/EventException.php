<?php

namespace App\Exception\Http;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

class EventException extends HttpException
{
    #[Pure]
    final public static function invalidRangeFromTime(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::CHECK_CORRECTNESS, 'event@invalidRangeFromTime', data: $data, headers: $headers);
    }
}