<?php

namespace App\Rest\Http\Exceptions;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

class EventException extends ApiResponseException
{
    #[Pure]
    final public static function invalidRangeFromTime(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::CHECK_CORRECTNESS, 'event@invalidRangeFromTime', data: $data, headers: $headers);
    }
}