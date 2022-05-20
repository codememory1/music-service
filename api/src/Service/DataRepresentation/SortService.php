<?php

namespace App\Service\DataRepresentation;

/**
 * Class SortService.
 *
 * @package App\Service\DataRepresentation
 *
 * @author  Codememory
 */
class SortService extends AbstractDataRepresentation
{
    /**
     * @inheritDoc
     */
    protected ?string $keyName = 'sort';

    /**
     * @inheritDoc
     */
    protected ?string $schemaName = 'sort';

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