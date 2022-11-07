<?php

namespace App\Rest\Response\Scheme;

use App\Enum\PlatformCodeEnum;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Rest\Response\Interfaces\WebSocketSchemeInterface;

final class WebSocketSuccessScheme extends AbstractSchemePrototype implements WebSocketSchemeInterface
{
    public function __construct(
        private readonly PlatformCodeEnum $platformCode,
        private readonly WebSocketClientMessageTypeEnum $clientMessageType,
        private readonly array $data
    ) {
    }

    public function use(): array
    {
        return [
            'type' => $this->clientMessageType->name,
            'platform_code' => $this->platformCode->value,
            'data' => $this->data
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