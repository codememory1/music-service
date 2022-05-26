<?php

namespace App\Rest\Http\Exceptions;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

/**
 * Class AccessDeniedException.
 *
 * @package App\Rest\Http\Exceptions
 *
 * @author  Codememory
 */
class AccessDeniedException extends ApiResponseException
{
    /**
     * @return static
     */
    #[Pure]
    public static function notEnoughPermissions(): self
    {
        return new self(403, ResponseTypeEnum::CHECK_ACCESS, 'accessDenied@notEnoughPermissions');
    }
}