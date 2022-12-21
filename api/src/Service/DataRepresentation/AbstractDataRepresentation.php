<?php

namespace App\Service\DataRepresentation;

use App\Rest\Http\Request;
use App\Service\SchemaValidator;
use function is_array;
use LogicException;

abstract class AbstractDataRepresentation
{
    protected ?string $keyName = null;
    protected ?string $schemaName = null;
    protected bool $asMultiple = true;
    protected readonly array $dataRepresentation;

    public function __construct(
        private readonly Request $request,
        private readonly SchemaValidator $schemaValidator
    ) {
        $this->dataRepresentation = $this->collectSettings();
    }

    abstract public function get(string $name): mixed;

    abstract public function exist(string $name): bool;

    public function all(): array
    {
        return $this->dataRepresentation;
    }

    private function collectSettings(): array
    {
        if (null === $this->keyName) {
            throw new LogicException(sprintf('The name of the key with the settings for data representation in the %s class is not set', static::class));
        }

        $data = $this->getData();

        if ($this->schemaValidator->validate($this->schemaName, $this->asMultiple ? array_values($data) : $data)) {
            return $data;
        }

        return [];
    }

    private function getData(): array
    {
        $settings = $this->request->getRequest()?->query->all()[$this->keyName] ?? false;

        if (false === $settings || !is_array($settings)) {
            return [];
        }

        return $settings;
    }
}