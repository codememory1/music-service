<?php

namespace App\Tests\Traits;

use function call_user_func;

trait SortableTrait
{
    private function sortByAsc(array $data, ?string $byKey = null, ?callable $customByKey = null): array
    {
        uasort($data, static function(array $first, array $second) use ($byKey, $customByKey) {
            if (null !== $customByKey) {
                [$first, $second] = call_user_func($customByKey, $first, $second);
            } else {
                if (null !== $byKey) {
                    $first = $first[$byKey];
                    $second = $second[$byKey];
                }
            }

            if ($first === $second) {
                return 0;
            }

            return $first < $second ? -1 : 1;
        });

        return $data;
    }

    private function sortByDesc(array $data, ?string $byKey = null, ?callable $customByKey = null): array
    {
        uasort($data, static function(array $first, array $second) use ($byKey, $customByKey) {
            if (null !== $customByKey) {
                [$first, $second] = call_user_func($customByKey, $first, $second);
            } else {
                if (null !== $byKey) {
                    $first = $first[$byKey];
                    $second = $second[$byKey];
                }
            }

            if ($first === $second) {
                return 0;
            }

            return $first > $second ? -1 : 1;
        });

        return $data;
    }
}