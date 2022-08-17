<?php

namespace App\Exception\Interfaces;

use App\Enum\WebSocketClientMessageTypeEnum;

interface WebSocketExceptionInterface
{
    public function getClientMessageType(): WebSocketClientMessageTypeEnum;

    public function getMessageTranslationKey(): string;

    public function getParameters(): array;
}