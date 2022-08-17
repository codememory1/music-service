<?php

namespace App\Exception\WebSocket;

use App\Enum\WebSocketClientMessageTypeEnum;
use App\Exception\Interfaces\WebSocketExceptionInterface;
use JetBrains\PhpStorm\Pure;
use RuntimeException;

class WebSocketException extends RuntimeException implements WebSocketExceptionInterface
{
    private WebSocketClientMessageTypeEnum $clientMessageType;
    private string $messageTranslationKey;
    private array $parameters;

    #[Pure]
    public function __construct(WebSocketClientMessageTypeEnum $clientMessageType, string $messageTranslationKey, array $parameters = [])
    {
        parent::__construct($messageTranslationKey);

        $this->clientMessageType = $clientMessageType;
        $this->messageTranslationKey = $messageTranslationKey;
        $this->parameters = $parameters;
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