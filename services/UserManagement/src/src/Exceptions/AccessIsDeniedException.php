<?php

namespace App\Exceptions;

use Codememory\ApiBundle\Exceptions\HttpException;

final class AccessIsDeniedException extends HttpException
{
    public static function authorizationFailedUserBlocked(): self
    {
        return new self(403, -1, 'auth.user_locked');
    }

    public static function authorizationFailedUserIsNotActivated(): self
    {
        return new self(403, -1, 'auth.user_not_activated');
    }
}