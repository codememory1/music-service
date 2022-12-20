<?php

namespace App\Exception\Http;

use App\Enum\PlatformCodeEnum;
use App\Exception\HttpException;
use JetBrains\PhpStorm\Pure;

class MultimediaException extends HttpException
{
    #[Pure]
    final public static function badTrackMimeType(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::MIME_TYPE_ERROR, 'multimedia@invalidTrackMimeType', $parameters, $headers);
    }

    #[Pure]
    final public static function badClipMimeType(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::MIME_TYPE_ERROR, 'multimedia@invalidClipMimeType', $parameters, $headers);
    }

    #[Pure]
    final public static function badSendOnModeration(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'multimedia@badSendOnModeration', $parameters, $headers);
    }

    #[Pure]
    final public static function badUnpublish(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'multimedia@badUnpublish', $parameters, $headers);
    }

    #[Pure]
    final public static function badPublish(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'multimedia@badPublish', $parameters, $headers);
    }

    #[Pure]
    final public static function badUpdateInStatus(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'multimedia@badUpdateInStatus', $parameters, $headers);
    }

    #[Pure]
    final public static function badSendOnAppeal(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'multimedia@badSendOnAppeal', $parameters, $headers);
    }

    #[Pure]
    final public static function badAppealCanceled(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'multimedia@badAppealCanceled', $parameters, $headers);
    }

    #[Pure]
    final public static function badAddMultimediaToUserInvalid(array $parameters = [], array $headers = []): self
    {
        return new self(
            400,
            PlatformCodeEnum::DO_NOT_HAVE_PERMISSION,
            'multimedia@badAddMultimediaToUserInvalidSubscription',
            $parameters,
            $headers
        );
    }

    #[Pure]
    final public static function badDuration(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::INVALID_META_DATA_IN_FILE, 'multimedia@badDuration', $parameters, $headers);
    }

    #[Pure]
    final public static function badAddRatingToNotPublishedMultimedia(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'multimedia.bad_add_rating.not_published', $parameters, $headers);
    }
}