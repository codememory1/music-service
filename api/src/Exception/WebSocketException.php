<?php

namespace App\Exception;

use App\Enum\PlatformCodeEnum;
use App\Exception\Interfaces\WebSocketExceptionInterface;
use JetBrains\PhpStorm\Pure;
use RuntimeException;

class WebSocketException extends RuntimeException implements WebSocketExceptionInterface
{
    #[Pure]
    public function __construct(
        protected readonly PlatformCodeEnum $platformCode,
        protected readonly string $text,
        protected readonly array $parameters = []
    ) {
        parent::__construct($this->text);
    }

    public function getPlatformCode(): PlatformCodeEnum
    {
        return $this->platformCode;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }
}