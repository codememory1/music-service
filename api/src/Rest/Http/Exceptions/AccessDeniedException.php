<?php

namespace App\Rest\Http\Exceptions;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

class AccessDeniedException extends ApiResponseException
{
    #[Pure]
    final public static function notEnoughPermissions(array $data = [], array $headers = []): self
    {
        return new self(403, ResponseTypeEnum::CHECK_ACCESS, 'accessDenied@notEnoughPermissions', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function notSubscription(array $data = [], array $headers = []): self
    {
        return new self(403, ResponseTypeEnum::CHECK_ACCESS, 'accessDenied@notSubscription', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function notEnoughSubscriptionPermissions(array $data = [], array $headers = []): self
    {
        return new self(403, ResponseTypeEnum::CHECK_ACCESS, 'accessDenied@notSubscriptionPermissions', data: $data, headers: $headers);
    }
}