<?php

namespace App\Rest\Response\Scheme;

use App\Enum\PlatformCodeEnum;
use App\Rest\Response\Interfaces\HttpSchemeInterface;

final class HttpErrorScheme extends AbstractSchemePrototype implements HttpSchemeInterface
{
    public function __construct(
        private readonly int $httpCode,
        private readonly PlatformCodeEnum $platformCode,
        private readonly string $message,
        private readonly array $parameters = []
    ) {
    }

    public function use(): array
    {
        return [
            'error' => [
                'http_code' => $this->httpCode,
                'platform_code' => $this->platformCode->value,
                'message' => $this->message,
                'message_parameters' => $this->parameters
            ]
        ];
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function getPlatformCode(): PlatformCodeEnum
    {
        return $this->platformCode;
    }

    public function __clone(): void
    {
    }
}