<?php

namespace App\DTO\Interceptors;

use App\DTO\Interfaces\ValueInterceptorInterface;
use const JSON_ERROR_NONE;

/**
 * Class AsArrayInterceptor.
 *
 * @package App\DTO\Interceptors
 *
 * @author  Codememory
 */
final class AsArrayInterceptor implements ValueInterceptorInterface
{
    /**
     * @inheritDoc
     */
    public function handle(string $key, mixed $value): array
    {
        $valueToArray = json_decode($value, true);

        if (empty($value) || JSON_ERROR_NONE !== json_last_error()) {
            return [];
        }

        return $valueToArray;
    }
}