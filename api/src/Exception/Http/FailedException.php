<?php

namespace App\Exception\Http;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

class FailedException extends HttpException
{
    #[Pure]
    final public static function failedToLogout(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'logout@failedToLogout', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function failedToUpdateAccessToken(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'common@failedToUpdateAccessToken', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function failedSubscribeOnArtist(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'artist@failedSubscribeOnArtist', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function failedUnsubscribeOnArtist(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'artist@failedUnsubscribeOnArtist', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function failedSendOnRequestRestorationPassword(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'passwordReset@blocked', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function failedAddAsFriendNotAccept(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'friend@notAccept', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function failedAddMyselfAsFriend(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'friend@addMyselfAsFriend', data: $data, headers: $headers);
    }
}