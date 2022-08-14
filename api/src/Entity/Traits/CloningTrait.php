<?php

namespace App\Entity\Traits;

trait CloningTrait
{
    public function __clone()
    {
        $this->id = null;
        $this->createdAt = null;
        $this->updatedAt = null;

        return $this;
    }
}