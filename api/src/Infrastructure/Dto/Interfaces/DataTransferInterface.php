<?php

namespace App\Infrastructure\Dto\Interfaces;

use App\Entity\Interfaces\EntityInterface;

interface DataTransferInterface
{
    public function setEntity(EntityInterface $entity): self;

    public function getEntity(): ?EntityInterface;

    public function collect(array $data): static;

    public function addValidateConstraints(string $propertyName, array $constraints): self;
}