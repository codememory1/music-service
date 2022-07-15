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
    private bool $isForce;

    public function __construct(bool $isForce = false)
    {
        $this->isForce = $isForce;
    }

    public function handle(string $key, mixed $value): ?float
    {
        if (false === empty($value) || true === $this->isForce) {
            return (float) $value;
        }

        return null;
    }
}