<?php

namespace App\Rest\Response\Scheme;

use App\Enum\PlatformCodeEnum;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Rest\Response\Interfaces\WebSocketSchemeInterface;

final class WebSocketErrorScheme extends AbstractSchemePrototype implements WebSocketSchemeInterface
{
    public function __construct(
        public readonly PlatformCodeEnum $platformCode,
        public readonly WebSocketClientMessageTypeEnum $clientMessageType,
        public readonly string $message,
        public readonly array $parameters = []
    ) {
    }

    public function use(): array
    {
        return [
            'type' => $this->clientMessageType->name,
            'platform_code' => $this->platformCode->value,
            'error' => [
                'message' => $this->message,
                'message_parameters' => $this->parameters
            ]
        ];
    }

    public function getClientMessageType(): WebSocketClientMessageTypeEnum
    {
        return $this->clientMessageType;
    }

    public function __clone(): void
    {
    }
}