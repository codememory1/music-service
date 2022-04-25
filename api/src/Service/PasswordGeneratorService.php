<?php

namespace App\Service;

use Exception;

/**
 * Class PasswordGeneratorService
 *
 * @package App\Service
 *
 * @author  Codememory
 */
class PasswordGeneratorService
{
    public const DEFAULT_LENGTH = 16;

    /**
     * @var array
     */
    private static array $characters = [
        0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'k',
        'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u',
        'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K',
        'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U',
        'V', 'W', 'X', 'Y', 'Z',
        '-', '_', '%', '.', '$', '#'
    ];

    /**
     * @throws Exception
     */
    public static function generate(int $length = 16): string
    {
        $length = $length < 1 ? self::DEFAULT_LENGTH : $length;
        $countCharacters = count(self::$characters) - 1;
        $password = null;

        for ($i = 0; $i < $length; $i++) {
            $password .= static::$characters[random_int(0, $countCharacters)];
        }

        return $password;
    }
}