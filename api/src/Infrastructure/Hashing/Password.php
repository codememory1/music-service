<?php

namespace App\Infrastructure\Hashing;

use const PASSWORD_ARGON2ID;

final class Password
{
    public function encode(string $password): string
    {
        return password_hash(hash('sha256', $password), PASSWORD_ARGON2ID, ['cost' => 10]);
    }

    public function compare(string $password, ?string $hash): bool
    {
        if (null === $hash) {
            return false;
        }

        return password_verify(hash('sha256', $password), $hash);
    }
}