<?php

namespace App\Service\DataRepresentation;

class SortService extends AbstractDataRepresentation
{
    protected ?string $keyName = 'sort';
    protected ?string $schemaName = 'sort';

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