<?php

namespace App\DTO\Interceptors;

use App\DTO\Interfaces\ValueInterceptorInterface;
use DateTimeImmutable;
use Exception;

/**
 * Class AsDateTimeInterceptor.
 *
 * @package App\DTO\Interceptors
 *
 * @author  Codememory
 */
final class AsDateTimeInterceptor implements ValueInterceptorInterface
{
    private bool $nullableAsNow;

    public function __construct(bool $nullableAsNow = false)
    {
        $this->nullableAsNow = $nullableAsNow;
    }

    public function handle(string $key, mixed $value): ?DateTimeImmutable
    {
        if (false === $this->nullableAsNow && empty($value)) {
            return null;
        }

        try {
            return new DateTimeImmutable($value);
        } catch (Exception) {
            return null;
        }
    }
}