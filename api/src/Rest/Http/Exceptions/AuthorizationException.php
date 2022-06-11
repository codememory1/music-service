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
    /**
     * @return static
     */
    #[Pure]
    public static function failedToIdentify(): self
    {
        return new self(400, ResponseTypeEnum::NOT_EXIST, 'user@failedToIdentify');
    }

    /**
     * @return static
     */
    #[Pure]
    public static function incorrectPassword(): self
    {
        return new self(400, ResponseTypeEnum::CHECK_CORRECTNESS, 'common@incorrectPassword');
    }

    /**
     * @return static
     */
    #[Pure]
    public static function authorizedIsRequired(): self
    {
        return new self(401, ResponseTypeEnum::CHECK_AUTH, 'auth@authRequired');
    }

    /**
     * @return static
     */
    #[Pure]
    public static function authorizedIsNotRequired(): self
    {
        return new self(400, ResponseTypeEnum::CHECK_AUTH, 'auth@authNotRequired');
    }

    /**
     * @return static
     */
    #[Pure]
    public static function authorizationError(): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'auth@authError');
    }

    /**
     * @return static
     */
    #[Pure]
    public static function didNotProvideData(): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'registration@didNotProvideData');
    }
}