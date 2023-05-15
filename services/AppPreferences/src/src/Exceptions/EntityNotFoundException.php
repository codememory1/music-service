<?php

namespace App\Exceptions;

use Codememory\ApiBundle\Exceptions\HttpException;

final class EntityNotFoundException extends HttpException
{
    public function __construct(int $platformCode, string $message, array $messageParameters = [], array $headers = [])
    {
        parent::__construct(404, $platformCode, $message, $messageParameters, $headers);
    }

    public static function preference(): self
    {
        return new self(-1, 'entity_not_found.preference');
    }
}