<?php

namespace App\Service;

use const PASSWORD_ARGON2ID;

/**
 * Class HashingService.
 *
 * @package App\Service
 *
 * @author  Codememory
 */
class HashingService
{
    final public function encode(string $password): string
    {
        return password_hash(hash('sha256', $password), PASSWORD_ARGON2ID, ['cost' => 10]);
    }

    final public function compare(string $password, string $hash): bool
    {
        return password_verify(hash('sha256', $password), $hash);
    }
}