<?php

namespace App\Rest\Http;

use App\Enum\ResponseTypeEnum;
use App\Rest\Http\Interfaces\ResponseSchemaInterface;

class ResponseSchema implements ResponseSchemaInterface
{
    private array $schema = [
        'status_code' => null,
        'type' => null,
        'message' => [],
        'data' => []
    ];

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

    public function setMessage(string $message, array $parameters = []): self
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

    public function __clone(): void
    {
        $this->schema['status_code'] = null;
        $this->schema['type'] = null;
        $this->schema['message'] = [];
        $this->schema['data'] = [];
    }
}