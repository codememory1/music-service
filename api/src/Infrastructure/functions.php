<?php

if (false === \function_exists('arr_value_by_string_keys')) {
    function arr_value_by_string_keys(array $array, string $keys, mixed $defaultIfNotExist = null)
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