<?php

namespace App\DTO\Interceptor;

use App\Rest\DTO\AbstractInterceptor;

/**
 * Class AlbumInputTagsInterceptor.
 *
 * @package App\DTO\Interceptor
 *
 * @author  Codememory
 */
class AlbumInputTagsInterceptor extends AbstractInterceptor
{
    /**
     * @inheritDoc
     */
    public function process(string $requestKey, mixed $requestValue): array
    {
        $tags = explode(',', $requestValue);

        if (empty($requestValue)) {
            return [];
        }

        return array_map(fn(string|int $value) => trim($value), $tags);
    }
}