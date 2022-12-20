<?php

namespace App\Exception\Http;

use App\Enum\PlatformCodeEnum;
use App\Exception\HttpException;
use JetBrains\PhpStorm\Pure;

class AuthorizationException extends HttpException
{
    #[Pure]
    final public static function failedToIdentify(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::ENTITY_NOT_FOUND, 'user@failedToIdentify', $parameters, $headers);
    }

    #[Pure]
    final public static function incorrectPassword(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::DATA_DOES_NOT_MATCH, 'common@incorrectPassword', $parameters, $headers);
    }

    #[Pure]
    final public static function authorizedIsRequired(array $parameters = [], array $headers = []): self
    {
        return new self(401, PlatformCodeEnum::AUTHORIZATION_REQUIRED, 'auth@authRequired', $parameters, $headers);
    }

    #[Pure]
    final public static function authorizedIsNotRequired(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::AUTHORIZATION_NOT_REQUIRED, 'auth@authNotRequired', $parameters, $headers);
    }

    #[Pure]
    final public static function authorizationError(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'auth@authError', $parameters, $headers);
    }

    #[Pure]
    final public static function didNotProvideData(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::NOT_ENOUGH_DATA, 'registration@didNotProvideData', $parameters, $headers);
    }
}