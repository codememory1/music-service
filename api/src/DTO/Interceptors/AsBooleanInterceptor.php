<?php

namespace App\DTO\Interceptors;

use App\DTO\Interfaces\ValueInterceptorInterface;

/**
 * Class AsBooleanInterceptor.
 *
 * @package App\DTO\Interceptors
 *
 * @author  Codememory
 */
class AsBooleanInterceptor implements ValueInterceptorInterface
{
    /**
     * @inheritDoc
     */
    public function handle(string $key, mixed $value): bool
    {
        return !('false' === $value || empty($value));
    }
}