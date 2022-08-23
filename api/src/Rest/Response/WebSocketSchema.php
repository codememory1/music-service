<?php

namespace App\Rest\Response;

use App\Enum\WebSocketClientMessageTypeEnum;
use App\Rest\Response\Interfaces\ResponseSchemaInterface;

class WebSocketSchema implements ResponseSchemaInterface
{
    private array $schema = [
        'type' => null,
        'result' => []
    ];
    private array $parameters = [];

    public function setType(WebSocketClientMessageTypeEnum $clientMessageType): self
    {
        $this->schema['type'] = $clientMessageType->name;

        return $this;
    }

    public function setError(string $message): self
    {
        $this->schema['error'] = [
            'message' => $message
        ];

        return $this;
    }

    public function setResult(array $result): self
    {
        $this->schema['result'] = $result;

        return $this;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function getSchema(): array
    {
        return $this->schema;
    }
}