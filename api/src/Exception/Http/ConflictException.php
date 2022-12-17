<?php

namespace App\Exception\Http;

use App\Enum\PlatformCodeEnum;
use App\Exception\HttpException;

class ConflictException extends HttpException
{
    public function __construct(PlatformCodeEnum $platformCode, string $text, array $parameters = [], array $headers = [])
    {
        parent::__construct(409, $platformCode, $text, $parameters, $headers);
    }

    final public static function userByEmailExist(array $parameters = [], array $headers = []): self
    {
        return new self(PlatformCodeEnum::ENTITY_FOUND, 'register.user_by_email_exist', $parameters, $headers);
    }
}