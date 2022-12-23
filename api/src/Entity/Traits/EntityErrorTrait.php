<?php

namespace App\Entity\Traits;

use Doctrine\Common\Collections\Collection;

trait EntityErrorTrait
{
    public function getEntityErrors(): Collection
    {
        return $this->entityErrors;
    }

    public function isOkEntityErrors(): bool
    {
        return $this->entityErrors->count() < 1;
    }
}