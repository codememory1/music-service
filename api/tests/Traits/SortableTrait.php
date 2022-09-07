<?php

namespace App\Tests\Traits;

trait SortableTrait
{
    private function sortByAsc(array $data, string $byKey): array
    {
        uasort($data, static function(array $first, array $second) use ($byKey) {
            if ($first[$byKey] === $second[$byKey]) {
                return 0;
            }

            return $first[$byKey] < $second[$byKey] ? -1 : 1;
        });

        return $data;
    }

    private function sortByDesc(array $data, string $byKey): array
    {
        uasort($data, static function(array $first, array $second) use ($byKey) {
            if ($first[$byKey] === $second[$byKey]) {
                return 0;
            }

            return $first[$byKey] > $second[$byKey] ? -1 : 1;
        });

        return $data;
    }
}