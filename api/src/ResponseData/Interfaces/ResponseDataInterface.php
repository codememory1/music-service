<?php

namespace App\ResponseData\Interfaces;

use App\Entity\Interfaces\EntityInterface;

/**
 * Interface ResponseDataInterface.
 *
 * @package  App\ResponseData\Interfaces
 *
 * @author   Codememory
 */
interface ResponseDataInterface
{
    public function setIgnoreProperty(string $name): self;

    /**
     * @param array<EntityInterface>|EntityInterface $entities
     */
    public function setEntities(EntityInterface|array $entities): self;

    public function collect(): self;

    public function getResponse(bool $first = false): array;
}