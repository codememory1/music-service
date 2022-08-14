<?php

namespace App\Service\DataRepresentation;

class FilterService extends AbstractDataRepresentation
{
    protected ?string $keyName = 'filter';
    protected ?string $schemaName = 'filter';

    public function get(string $name): mixed
    {
        foreach ($this->dataRepresentation as $data) {
            if ($data['name'] === $name) {
                return $data['value'];
            }
        }

        return false;
    }

    public function exist(string $name): bool
    {
        return false !== $this->get($name);
    }
}