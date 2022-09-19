<?php

namespace App\Exception\Http;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

class InvalidInputValidationException extends HttpException
{
    #[Pure]
    public static function multimediaTimeCodeAlreadyAdded(array $data = [], array $headers = []): self
    {
        return new self(422, ResponseTypeEnum::INPUT_VALIDATION, 'multimediaTimeCode@timeCodeAlreadyAdded', data: $data, headers: $headers);
    }

    #[Pure]
    public static function multimediaTimeCodeToMoreDuration(array $data = [], array $headers = []): self
    {
        return new self(422, ResponseTypeEnum::INPUT_VALIDATION, 'multimediaTimeCode@toTimeMoreDuration', data: $data, headers: $headers);
    }
}