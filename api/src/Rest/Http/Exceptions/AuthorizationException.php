<?php

namespace App\Rest\Http\Exceptions;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

/**
 * Class AuthorizationException.
 *
 * @package App\Rest\Http\Exceptions
 *
 * @author  Codememory
 */
class AuthorizationException extends ApiResponseException
{
    #[Pure]
    final public static function failedToIdentify(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::NOT_EXIST, 'user@failedToIdentify', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function incorrectPassword(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::CHECK_CORRECTNESS, 'common@incorrectPassword', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function authorizedIsRequired(array $data = [], array $headers = []): self
    {
        return new self(401, ResponseTypeEnum::CHECK_AUTH, 'auth@authRequired', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function authorizedIsNotRequired(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::CHECK_AUTH, 'auth@authNotRequired', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function authorizationError(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'auth@authError', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function didNotProvideData(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'registration@didNotProvideData', data: $data, headers: $headers);
    }
}