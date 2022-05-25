<?php

namespace App\Rest\Http\Exceptions;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

/**
 * Class FailedException.
 *
 * @package App\Rest\Http\Exceptions
 *
 * @author  Codememory
 */
class FailedException extends ApiResponseException
{
    /**
     * @return static
     */
    #[Pure]
    public static function failedToLogout(): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'logout@failedToLogout');
    }

    /**
     * @return static
     */
    #[Pure]
    public static function failedToUpdateAccessToken(): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'common@failedToUpdateAccessToken');
    }
}