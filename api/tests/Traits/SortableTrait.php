<?php

namespace App\Tests\Traits;

trait SortableTrait
{
    private function sortByAsc(array $data, string $byKey): array
    {
        uasort($data, static fn(array $first, array $second) => $first[$byKey] < $second[$byKey] ? -1 : 1);

        return $data;
    }

    private function sortByDesc(array $data, string $byKey): array
    {
        uasort($data, static fn(array $first, array $second) => $first[$byKey] > $second[$byKey] ? -1 : 1);

        return $data;
    }
}