<?php

namespace App\Rest\Response\Interfaces;

use App\Enum\WebSocketClientMessageTypeEnum;

interface WebSocketSchemeInterface extends SchemePrototypeInterface
{
    public function getClientMessageType(): WebSocketClientMessageTypeEnum;
}