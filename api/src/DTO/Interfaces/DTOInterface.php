<?php

namespace App\DTO\Interfaces;

use App\Entity\Interfaces\EntityInterface;

/**
 * Interface DTOInterface.
 *
 * @package  App\DTO\Interfaces
 *
 * @author   Codememory
 */
interface DTOInterface
{
    public function setRequestType(string $type): self;

    public function preventSetterCallForKeys(array $propertyNames): self;

    public function collect(): self;

    public function setEntity(EntityInterface $entity): self;

    public function getEntity(): ?EntityInterface;
}