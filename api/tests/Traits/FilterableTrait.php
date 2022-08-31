<?php

namespace App\Tests\Traits;

trait FilterableTrait
{
    private function filter(array $data, string $byKey, mixed $value): array
    {
        return array_filter($data, static fn(array $item) => $item[$byKey] === $value);
    }
}