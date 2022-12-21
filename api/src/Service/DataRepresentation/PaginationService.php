<?php

namespace App\Service\DataRepresentation;

class PaginationService extends AbstractDataRepresentation
{
    protected ?string $keyName = 'pagination';
    protected ?string $schemaName = 'pagination';
    protected bool $asMultiple = false;

    public function get(string $name): mixed
    {
        foreach ($this->dataRepresentation as $key => $value) {
            if ($key === $name) {
                return $value;
            }
        }

        return false;
    }

    public function exist(string $name): bool
    {
        return false !== $this->get($name);
    }
}