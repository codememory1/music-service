<?php

namespace App\DTO\Interceptors;

use App\DTO\Interfaces\ValueInterceptorInterface;

/**
 * Class AsFloatOrNullInterceptor.
 *
 * @package App\DTO\Interceptors
 *
 * @author  Codememory
 */
class AsFloatOrNullInterceptor implements ValueInterceptorInterface
{
    public function handle(string $key, mixed $value): ?float
    {
        return empty($value) ? null : (float) $value;
    }
}