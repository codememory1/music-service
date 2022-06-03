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
    final public static function notEnoughPermissions(): self
    {
        return new self(403, ResponseTypeEnum::CHECK_ACCESS, 'accessDenied@notEnoughPermissions');
    }

    /**
     * @return static
     */
    #[Pure]
    final public static function notSubscription(): self
    {
        return new self(403, ResponseTypeEnum::CHECK_ACCESS, 'accessDenied@notSubscription');
    }

    /**
     * @return static
     */
    #[Pure]
    final public static function notEnoughSubscriptionPermissions(): self
    {
        return new self(403, ResponseTypeEnum::CHECK_ACCESS, 'accessDenied@notSubscriptionPermissions');
    }
}