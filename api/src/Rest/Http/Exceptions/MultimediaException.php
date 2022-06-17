<?php

namespace App\Rest\Http\Exceptions;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;

/**
 * Class MultimediaException.
 *
 * @package App\Rest\Http\Exceptions
 *
 * @author  Codememory
 */
class MultimediaException extends ApiResponseException
{
    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function badTrackMimeType(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::CHECK_VALID, 'multimedia@invalidTrackMimeType', data: $data, headers: $headers);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return static
     */
    #[Pure]
    final public static function badClipMimeType(array $data = [], array $headers = []): self
    {
        return new self(400, ResponseTypeEnum::CHECK_VALID, 'multimedia@invalidClipMimeType', data: $data, headers: $headers);
    }
}