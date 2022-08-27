<?php

namespace App\Tests\Traits;

trait SecurityTrait
{
    private function register(?string $email = null): string
    {
        $email ??= 'test-user@gmail.com';

        $this->createRequest('/api/ru/public/user/register', 'POST', [
            'pseudonym' => 'Codememory',
            'email' => $email,
            'password' => 'test_user_password',
            'password_confirm' => 'test_user_password'
        ]);

        return $email;
    }
}