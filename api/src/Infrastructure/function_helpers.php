<?php

if (false === \function_exists('encode_reserved_url_chars')) {
    function encode_reserved_url_chars(string $string): string
    {
        $symbolForReplaced = [
            ' ' => '%20',
            '!' => '%21',
            '"' => '%22',
            '#' => '%23',
            '$' => '%24',
            '&' => '%26',
            '\'' => '%27',
            '(' => '%28',
            ')' => '%29',
            '*' => '%2A',
            '.' => '%2E',
            '/' => '%2F',
            '<' => '%3C',
            '>' => '%3E',
            '|' => '%7C'
        ];

        return str_replace(array_keys($symbolForReplaced), $symbolForReplaced, $string);
    }
}