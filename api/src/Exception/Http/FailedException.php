<?php

namespace App\Exception\Http;

use App\Enum\PlatformCodeEnum;
use App\Exception\HttpException;
use JetBrains\PhpStorm\Pure;

class FailedException extends HttpException
{
    #[Pure]
    final public static function failedToLogout(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'logout@failedToLogout', $parameters, $headers);
    }

    #[Pure]
    final public static function failedToUpdateAccessToken(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'common@failedToUpdateAccessToken', $parameters, $headers);
    }

    #[Pure]
    final public static function failedSubscribeOnArtist(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'artist@failedSubscribeOnArtist', $parameters, $headers);
    }

    #[Pure]
    final public static function failedUnsubscribeOnArtist(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'artist@failedUnsubscribeOnArtist', $parameters, $headers);
    }

    #[Pure]
    final public static function failedSendOnRequestRestorationPassword(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'passwordReset@blocked', $parameters, $headers);
    }

    #[Pure]
    final public static function failedAddAsFriendNotAccept(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'friend@notAccept', $parameters, $headers);
    }

    #[Pure]
    final public static function failedAddMyselfAsFriend(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'friend@addMyselfAsFriend', $parameters, $headers);
    }
}