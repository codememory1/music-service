<?php

namespace App\Rest\Http\Exceptions;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

/**
 * Class AuthorizationException
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
}