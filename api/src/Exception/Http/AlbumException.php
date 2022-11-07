<?php

namespace App\Exception\Http;

use App\Enum\PlatformCodeEnum;
use App\Exception\HttpException;
use JetBrains\PhpStorm\Pure;

class AlbumException extends HttpException
{
    #[Pure]
    final public static function badAddMultimediaToSingleAlbum(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'album@badAddMultimediaToSingleAlbum', $parameters, $headers);
    }

    #[Pure]
    final public static function badPublicationToAlreadyPublication(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'album@badPublicationToAlreadyPublication', $parameters, $headers);
    }

    #[Pure]
    final public static function badPublicationWithoutPublishedMultimedia(array $parameters = [], array $headers = []): self
    {
        return new self(400, PlatformCodeEnum::UNEXPECTED_ERROR, 'album@badPublicationWithoutPublishedMultimedia', $parameters, $headers);
    }
}