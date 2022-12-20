<?php

namespace App\Entity\Traits;

use DateTimeImmutable;

trait ValidTtlTrait
{
    public function isValidTtlByCreatedAt(): bool
    {
        $createdAt = $this->getCreatedAt()->getTimestamp();
        $now = (new DateTimeImmutable())->getTimestamp();

        return false === $now > $createdAt + $this->getTtl();
    }

    public function isValidTtlWithUpdatedAt(): bool
    {
        $createdAt = $this->getCreatedAt()->getTimestamp();
        $now = (new DateTimeImmutable())->getTimestamp();

        if (null !== $this->getUpdatedAt()) {
            $createdAt = $this->getUpdatedAt()->getTimestamp();
        }

        return false === $now > $createdAt + $this->getTtl();
    }
}