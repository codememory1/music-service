<?php

namespace App\Service\DataRepresentation;

/**
 * Class FilterService.
 *
 * @package App\Service\DataRepresentation
 *
 * @author  Codememory
 */
class FilterService extends AbstractDataRepresentation
{
    /**
     * @inheritDoc
     */
    protected ?string $keyName = 'filter';

    /**
     * @inheritDoc
     */
    protected ?string $schemaName = 'filter';

    /**
     * @inheritDoc
     */
    public function get(string $name): mixed
    {
        foreach ($this->dataRepresentation as $data) {
            if ($data['name'] === $name) {
                return $data['value'];
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function exist(string $name): bool
    {
        return false !== $this->get($name);
    }
}