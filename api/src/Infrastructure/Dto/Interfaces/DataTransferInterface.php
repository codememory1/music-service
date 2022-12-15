<?php

namespace App\Infrastructure\Dto\Interfaces;

use App\Entity\Interfaces\EntityInterface;
use App\Infrastructure\Dto\DtoValidationRepository;

interface DataTransferInterface
{
    public function setEntity(EntityInterface $entity): self;

    public function getEntity(): ?EntityInterface;

    public function collect(array $data): static;

    public function getValidationRepository(): DtoValidationRepository;
}