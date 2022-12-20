<?php

namespace App\Tests\Traits;

use function call_user_func;

trait FilterableTrait
{
    private function filter(array $data, string $byKey, mixed $value): array
    {
        return array_filter($data, static fn(array $item) => $item[$byKey] === $value);
    }

    private function filterByCallback(array $data, callable $callback): array
    {
        return array_filter($data, static fn(array $item) => call_user_func($callback, $item));
    }
}