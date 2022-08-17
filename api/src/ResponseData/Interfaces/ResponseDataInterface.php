<?php

namespace App\ResponseData\Interfaces;

use App\Entity\Interfaces\EntityInterface;

interface ResponseDataInterface
{
    public function setIgnoreProperty(string $name): self;

    /**
     * @param array<EntityInterface>|EntityInterface $entities
     */
    public function setEntities(EntityInterface|array $entities): self;

    public function getResponse(bool $first = false): array;
}