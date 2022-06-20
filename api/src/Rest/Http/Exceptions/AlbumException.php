<?php

namespace App\Rest\Http\Exceptions;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

/**
 * Class AlbumException.
 *
 * @package App\Rest\Http\Exceptions
 *
 * @author  Codememory
 */
class AlbumException extends ApiResponseException
{
    /**
     * @return static
     */
    #[Pure]
    final public static function badAddMultimediaToSingleAlbum(): self
    {
        return new self(400, ResponseTypeEnum::FAILED, 'album@badAddMultimediaToSingleAlbum');
    }
}