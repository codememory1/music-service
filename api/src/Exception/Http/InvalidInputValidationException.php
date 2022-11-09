<?php

namespace App\Exception\Http;

use App\Enum\PlatformCodeEnum;
use App\Exception\HttpException;
use JetBrains\PhpStorm\Pure;

class InvalidInputValidationException extends HttpException
{
    #[Pure]
    public static function multimediaTimeCodeAlreadyAdded(array $parameters = [], array $headers = []): self
    {
        return new self(422, PlatformCodeEnum::UNEXPECTED_ERROR, 'multimediaTimeCode@timeCodeAlreadyAdded', $parameters, $headers);
    }

    #[Pure]
    public static function multimediaTimeCodeToMoreDuration(array $parameters = [], array $headers = []): self
    {
        return new self(422, PlatformCodeEnum::TEXT_ENTRY_VALIDATION_ERROR, 'multimediaTimeCode@toTimeMoreDuration', $parameters, $headers);
    }
}