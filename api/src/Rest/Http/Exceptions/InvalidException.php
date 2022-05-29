<?php

namespace App\Rest\Http\Exceptions;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

/**
 * Class InvalidException.
 *
 * @package App\Rest\Http\Exceptions
 *
 * @author  Codememory
 */
class InvalidException extends ApiResponseException
{
    /**
     * @return static
     */
    #[Pure]
    public static function invalidRefreshToken(): self
    {
        return new self(400, ResponseTypeEnum::CHECK_VALID, 'common@invalidRefreshToken');
    }

    /**
     * @return static
     */
    #[Pure]
    public static function invalidCode(): self
    {
        return new self(400, ResponseTypeEnum::CHECK_VALID, 'common@invalidCode');
    }
}