<?php

namespace App\Rest\Response\Interfaces;

use App\Enum\WebSocketClientMessageTypeEnum;

interface WebSocketResponseCollectorInterface extends ResponseCollectorInterface
{
    public function getClientType(): WebSocketClientMessageTypeEnum;

    public function setClientType(WebSocketClientMessageTypeEnum $type): self;
}