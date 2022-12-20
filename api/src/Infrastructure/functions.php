<?php

if (false === \function_exists('arr_value_by_string_keys')) {
    function arr_value_by_string_keys(array $array, string $keys, mixed $defaultIfNotExist = null): array
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

if (false === \function_exists('tap')) {
    function tap(mixed $value, callable $callback): mixed
    {
        if (empty($value)) {
            return \call_user_func($callback);
        }

        return $value;
    }
}