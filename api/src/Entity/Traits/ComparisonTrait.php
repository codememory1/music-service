<?php

namespace App\Entity\Traits;

use App\Entity\Interfaces\EntityInterface;

trait ComparisonTrait
{
    public function isCompare(EntityInterface $entity): bool
    {
        return $this->getId() === $entity->getId();
    }
}