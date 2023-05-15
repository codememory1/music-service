<?php

namespace App\Exceptions;

use Codememory\ApiBundle\Exceptions\HttpException;

final class BadException extends HttpException
{
    public function __construct(int $platformCode, string $message, array $messageParameters = [], array $headers = [])
    {
        parent::__construct(400, $platformCode, $message, $messageParameters, $headers);
    }

    public static function invalidEmailOrPassword(): self
    {
        return new self(-1, 'bad.email_or_password_invalid');
    }

    public static function invalidAccountActivationCode(): self
    {
        return new self(-1, 'bad.account_activation_code');
    }
}