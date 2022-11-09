<?php

namespace App\Rest\Response\Scheme;

use App\Enum\PlatformCodeEnum;
use App\Rest\Response\Interfaces\HttpSchemeInterface;

final class HttpSuccessScheme extends AbstractSchemePrototype implements HttpSchemeInterface
{
    public function __construct(
        private readonly int $httpCode,
        private readonly PlatformCodeEnum $platformCode,
        private readonly array $data
    ) {
    }

    public function use(): array
    {
        return [
            'http_code' => $this->httpCode,
            'platform_code' => $this->platformCode,
            'data' => $this->data
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