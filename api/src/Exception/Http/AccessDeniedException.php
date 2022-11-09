<?php

namespace App\Exception\Http;

use App\Enum\PlatformCodeEnum;
use App\Exception\HttpException;
use JetBrains\PhpStorm\Pure;

class AccessDeniedException extends HttpException
{
    #[Pure]
    final public static function notEnoughPermissions(array $parameters = [], array $headers = []): self
    {
        return new self(403, PlatformCodeEnum::DO_NOT_HAVE_PERMISSION, 'accessDenied@notEnoughPermissions', $parameters, $headers);
    }

    #[Pure]
    final public static function notSubscription(array $parameters = [], array $headers = []): self
    {
        return new self(403, PlatformCodeEnum::DO_NOT_HAVE_PERMISSION, 'accessDenied@notSubscription', $parameters, $headers);
    }

    #[Pure]
    final public static function notEnoughSubscriptionPermissions(array $parameters = [], array $headers = []): self
    {
        return new self(403, PlatformCodeEnum::DO_NOT_HAVE_PERMISSION, 'accessDenied@notSubscriptionPermissions', $parameters, $headers);
    }
}