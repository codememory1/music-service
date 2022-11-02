<?php

namespace App\Exception\Http;

use App\Enum\ResponseTypeEnum;
use App\Exception\Interfaces\HttpExceptionInterface;
use JetBrains\PhpStorm\Pure;
use RuntimeException;

class HttpException extends RuntimeException implements HttpExceptionInterface
{
    #[Pure]
    public function __construct(
        private readonly int $statusCode,
        private readonly ResponseTypeEnum $responseType,
        private readonly string $messageTranslationKey,
        private readonly array $parameters = [],
        private readonly array $data = [],
        private readonly array $headers = []
    ) {
        parent::__construct($messageTranslationKey);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getResponseType(): ResponseTypeEnum
    {
        return $this->responseType;
    }

    public function getMessageTranslationKey(): string
    {
        return $this->messageTranslationKey;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}