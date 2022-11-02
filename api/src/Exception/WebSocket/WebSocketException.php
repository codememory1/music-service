<?php

namespace App\Exception\WebSocket;

use App\Enum\WebSocketClientMessageTypeEnum;
use App\Exception\Interfaces\WebSocketExceptionInterface;
use JetBrains\PhpStorm\Pure;
use RuntimeException;

class WebSocketException extends RuntimeException implements WebSocketExceptionInterface
{
    #[Pure]
    public function __construct(
        private readonly WebSocketClientMessageTypeEnum $clientMessageType,
        private readonly string $messageTranslationKey, 
        private readonly array $parameters = []
    ) {
        parent::__construct($messageTranslationKey);
    }

    public function getClientMessageType(): WebSocketClientMessageTypeEnum
    {
        return $this->clientMessageType;
    }

    public function getMessageTranslationKey(): string
    {
        return $this->messageTranslationKey;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }
}