<?php

namespace App\Rest\Http\Exceptions;

use App\Enum\MultimediaStatusEnum;
use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

class MultimediaException extends ApiResponseException
{
    #[Pure]
    final public static function badTrackMimeType(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::CHECK_VALID, 'multimedia@invalidTrackMimeType', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function badClipMimeType(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::CHECK_VALID, 'multimedia@invalidClipMimeType', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function badSendOnModeration(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'multimedia@badSendOnModeration', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function badUnpublish(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'multimedia@badUnpublish', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function badPublish(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'multimedia@badPublish', data: $data, headers: $headers);
    }

    final public static function badUpdateInStatus(string $status, array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'multimedia@badUpdateInStatus', [
            '@status' => MultimediaStatusEnum::getValueByName($status)
        ], data: $data, headers: $headers);
    }

    final public static function badSendOnAppeal(string $status, array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'multimedia@badSendOnAppeal', [
            '@status' => MultimediaStatusEnum::getValueByName($status)
        ], data: $data, headers: $headers);
    }

    #[Pure]
    final public static function badAppealCanceled(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'multimedia@badAppealCanceled', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function badAddMultimediaToUserInvalid(array $data = [], array $headers = []): self
    {
        return new self(
            400,
            ResponseTypeEnum::CHECK_CORRECTNESS,
            'multimedia@badAddMultimediaToUserInvalidSubscription',
            data: $data,
            headers: $headers
        );
    }

    #[Pure]
    final public static function badDuration(int $allowedDuration, array $data = [], array $headers = []): self
    {
        return new self(
            400,
            ResponseTypeEnum::FAILED,
            'multimedia@badDuration',
            ['allowed_duration' => $allowedDuration],
            $data,
            $headers
        );
    }
}