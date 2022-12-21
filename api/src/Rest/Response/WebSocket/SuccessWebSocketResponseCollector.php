<?php

namespace App\Rest\Response\WebSocket;

use App\Rest\Response\AbstractWebSocketResponseCollector;
use App\Rest\Response\Interfaces\SuccessWebSocketResponseCollectorInterface;
use App\Rest\Response\Interfaces\WebSocketResponseCollectorInterface;

final class SuccessWebSocketResponseCollector extends AbstractWebSocketResponseCollector implements SuccessWebSocketResponseCollectorInterface
{
    private array $response = [];
    private array $data = [];

    public function collect(): WebSocketResponseCollectorInterface
    {
        $this->response = [
            'type' => $this->getClientType()->name,
            'platform_code' => $this->getPlatformCode()->value,
            'data' => $this->data
        ];

        return $this;
    }

    public function getCollectedResponse(): array
    {
        return $this->response;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): SuccessWebSocketResponseCollectorInterface
    {
        $this->data = $data;

        return $this;
    }
}