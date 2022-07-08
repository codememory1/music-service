<?php

namespace App\DTO\Interceptors;

use App\DTO\Interfaces\ValueInterceptorInterface;
use DateTimeImmutable;
use Exception;

/**
 * Class AsDateInterceptor.
 *
 * @package App\DTO\Interceptors
 *
 * @author  Codememory
 */
final class AsDateInterceptor implements ValueInterceptorInterface
{
    public function handle(string $key, mixed $value): DateTimeImmutable
    {
        try {
            return new DateTimeImmutable($value);
        } catch (Exception) {
            return new DateTimeImmutable();
        }
    }
}