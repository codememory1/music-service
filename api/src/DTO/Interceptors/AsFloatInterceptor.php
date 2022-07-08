<?php

namespace App\DTO\Interceptors;

use App\DTO\Interfaces\ValueInterceptorInterface;

/**
 * Class AsFloatInterceptor.
 *
 * @package App\DTO\Interceptors
 *
 * @author  Codememory
 */
class AsFloatInterceptor implements ValueInterceptorInterface
{
    public function handle(string $key, mixed $value): float
    {
        return (float) $value;
    }
}