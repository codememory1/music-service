<?php

namespace App\Rest\Response\WebSocket;

use App\Rest\Response\AbstractWebSocketResponseCollector;
use App\Rest\Response\Interfaces\FailedWebSocketResponseCollectorInterface;
use App\Rest\Response\Interfaces\WebSocketResponseCollectorInterface;
use LogicException;

final class FailedWebSocketResponseCollector extends AbstractWebSocketResponseCollector implements FailedWebSocketResponseCollectorInterface
{
    private ?string $message = null;
    private array $messageParameters = [];
    private array $response = [];

    public function getMessage(): string
    {
        if (null === $this->message) {
            throw new LogicException('No message specified for failed WebSocket response');
        }

        return $this->message;
    }

    public function setMessage(string $message): FailedWebSocketResponseCollectorInterface
    {
        $this->message = $message;

        return $this;
    }

    public function getMessageParameters(): array
    {
        return $this->messageParameters;
    }

    public function setMessageParameters(array $parameters): FailedWebSocketResponseCollectorInterface
    {
        $this->messageParameters = $parameters;

        return $this;
    }

    public function collect(): WebSocketResponseCollectorInterface
    {
        $this->response = [
            'type' => $this->getClientType()->name,
            'platform_code' => $this->getPlatformCode()->value,
            'error' => [
                'message' => $this->getMessage(),
                'message_parameters' => $this->getMessageParameters()
            ]
        ];

        return $this;
    }

    public function getCollectedResponse(): array
    {
        return $this->response;
    }
}