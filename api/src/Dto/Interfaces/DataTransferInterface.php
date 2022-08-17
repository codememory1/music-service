<?php

namespace App\Dto\Interfaces;

use App\Entity\Interfaces\EntityInterface;

interface DataTransferInterface
{
    public function setEntity(EntityInterface $entity): self;

    public function getEntity(): ?EntityInterface;

    public function collect(array $data): static;
}