<?php

namespace App\Infrastructure\Support;

class Arr
{
    public static function getValueByStringKeys(array $array, string $keys, mixed $defaultIfNotExist = null): mixed
    {
        $localData = $array;
        
        foreach (explode('.', $keys) as $key) {
            if (array_key_exists($key, $array)) {
                $localData = $array[$key];
            } else {
                return $defaultIfNotExist;
            }
        }
        
        return $localData;
    }
}