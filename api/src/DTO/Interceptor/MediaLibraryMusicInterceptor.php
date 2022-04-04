<?php

namespace App\DTO\Interceptor;

use App\Rest\DTO\AbstractInterceptor;
use function is_array;
use const JSON_ERROR_NONE;

/**
 * Class MediaLibraryMusicInterceptor.
 *
 * @package App\DTO\Interceptor
 *
 * @author  Codememory
 */
class MediaLibraryMusicInterceptor extends AbstractInterceptor
{
    /**
     * @inheritDoc
     */
    public function process(string $requestKey, mixed $requestValue): mixed
    {
        $decodedValue = json_decode($requestValue, true);

        if (JSON_ERROR_NONE === json_last_error()) {
            return $decodedValue;
        }

        if (is_array($requestValue)) {
            return $requestValue;
        }

        return [];
    }
}