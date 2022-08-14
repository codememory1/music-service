<?php

namespace App\Service;

use const PASSWORD_ARGON2ID;

class HashingService
{
    final public function encode(string $password): string
    {
        return password_hash(hash('sha256', $password), PASSWORD_ARGON2ID, ['cost' => 10]);
    }

    final public function compare(string $password, ?string $hash): bool
    {
        if (null === $hash) {
            return false;
        }

        return password_verify(hash('sha256', $password), $hash);
    }
}