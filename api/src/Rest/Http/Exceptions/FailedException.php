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
    #[Pure]
    public static function failedToLogout(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'logout@failedToLogout', data: $data, headers: $headers);
    }

    #[Pure]
    public static function failedToUpdateAccessToken(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'common@failedToUpdateAccessToken', data: $data, headers: $headers);
    }

    #[Pure]
    public static function failedSubscribeOnArtist(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'artist@failedSubscribeOnArtist', data: $data, headers: $headers);
    }

    #[Pure]
    public static function failedUnsubscribeOnArtist(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'artist@failedUnsubscribeOnArtist', data: $data, headers: $headers);
    }

    #[Pure]
    public static function failedSendOnRequestRestorationPassword(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'passwordReset@blocked', data: $data, headers: $headers);
    }
}