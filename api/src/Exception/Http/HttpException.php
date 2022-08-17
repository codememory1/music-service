<?php

namespace App\Exception\Http;

use App\Enum\ResponseTypeEnum;
use App\Exception\Interfaces\HttpExceptionInterface;
use JetBrains\PhpStorm\Pure;
use RuntimeException;

class HttpException extends RuntimeException implements HttpExceptionInterface
{
    private int $statusCode;
    private ResponseTypeEnum $responseType;
    private string $messageTranslationKey;
    private array $parameters;
    private array $data;
    private array $headers;

    #[Pure]
    public function __construct(
        int $statusCode,
        ResponseTypeEnum $responseType,
        string $messageTranslationKey,
        array $parameters = [],
        array $data = [],
        array $headers = []
    ) {
        parent::__construct($messageTranslationKey);

        $this->statusCode = $statusCode;
        $this->responseType = $responseType;
        $this->messageTranslationKey = $messageTranslationKey;
        $this->parameters = $parameters;
        $this->data = $data;
        $this->headers = $headers;
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