<?php

namespace App\Rest\Response;

use App\Enum\WebSocketClientMessageTypeEnum;
use App\Rest\Response\Interfaces\WebSocketResponseCollectorInterface;
use LogicException;

abstract class AbstractWebSocketResponseCollector extends AbstractResponseCollector implements WebSocketResponseCollectorInterface
{
    private ?WebSocketClientMessageTypeEnum $clientType = null;

    public function getClientType(): WebSocketClientMessageTypeEnum
    {
        if (null === $this->clientType) {
            throw new LogicException(sprintf('No message type specified for response %s', static::class));
        }

        return $this->clientType;
    }

    public function setClientType(WebSocketClientMessageTypeEnum $type): WebSocketResponseCollectorInterface
    {
        $this->clientType = $type;

        return $this;
    }
}