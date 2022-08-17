<?php

namespace App\Rest\Response;

use App\Enum\ResponseTypeEnum;
use App\Rest\Response\Interfaces\ResponseSchemaInterface;

class HttpSchema implements ResponseSchemaInterface
{
    private array $schema = [
        'status_code' => null,
        'type' => null,
        'message' => [],
        'data' => []
    ];
    private array $parameters = [];

    public function setStatusCode(int $code): self
    {
        $this->schema['status_code'] = $code;

        return $this;
    }

    public function setType(ResponseTypeEnum $type): self
    {
        $this->schema['type'] = $type->name;

        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->schema['message'] = $message;

        return $this;
    }

    public function setData(array $data): self
    {
        $this->schema['data'] = $data;

        return $this;
    }

    public function getSchema(): array
    {
        return $this->schema;
    }

    public function getStatusCode(): int
    {
        $statusCode = $this->schema['status_code'];

        return empty($statusCode) ? 200 : $statusCode;
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

    public function __clone(): void
    {
        $this->schema['status_code'] = null;
        $this->schema['type'] = null;
        $this->schema['message'] = [];
        $this->schema['data'] = [];
    }
}