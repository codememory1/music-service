<?php

namespace App\Exception\Http;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

class AlbumException extends HttpException
{
    #[Pure]
    final public static function badAddMultimediaToSingleAlbum(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'album@badAddMultimediaToSingleAlbum', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function badPublicationToAlreadyPublication(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'album@badPublicationToAlreadyPublication', data: $data, headers: $headers);
    }

    #[Pure]
    final public static function badPublicationWithoutPublishedMultimedia(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'album@badPublicationWithoutPublishedMultimedia', data: $data, headers: $headers);
    }
}