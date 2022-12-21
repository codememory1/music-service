<?php

namespace App\Rest\Response\Interfaces;

interface SuccessWebSocketResponseCollectorInterface extends WebSocketResponseCollectorInterface
{
    public function getData(): array;

    public function setData(array $data): self;
}