<?php

namespace App\Rest\Http\Exceptions;

use App\Enum\ResponseTypeEnum;
use JetBrains\PhpStorm\Pure;
use RuntimeException;

class ApiResponseException extends RuntimeException
{
    public readonly string $translationKey;
    public readonly array $parameters;
    public readonly ResponseTypeEnum $type;
    public readonly int $statusCode;
    public readonly array $data;
    public readonly array $headers;

    #[Pure]
    public function __construct(int $statusCode, ResponseTypeEnum $type, string $translationKey, array $parameters = [], array $data = [], array $headers = [])
    {
        parent::__construct($translationKey);

        $this->translationKey = $translationKey;
        $this->parameters = $parameters;
        $this->type = $type;
        $this->statusCode = $statusCode;
        $this->data = $data;
        $this->headers = $headers;
    }
}