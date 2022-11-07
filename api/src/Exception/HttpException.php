<?php

namespace App\Exception;

use App\Enum\PlatformCodeEnum;
use App\Exception\Interfaces\HttpExceptionInterface;
use JetBrains\PhpStorm\Pure;
use RuntimeException;

class HttpException extends RuntimeException implements HttpExceptionInterface
{
    #[Pure]
    public function __construct(
        protected readonly int $httpCode,
        protected readonly PlatformCodeEnum $platformCode,
        protected readonly string $text,
        protected readonly array $parameters = [],
        protected readonly array $headers = []
    ) {
        parent::__construct($text);
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function getPlatformCode(): PlatformCodeEnum
    {
        return $this->platformCode;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}