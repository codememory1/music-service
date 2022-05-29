<?php

namespace App\Entity\Traits;

use DateTimeImmutable;

/**
 * Trait ValidTtlTrait.
 *
 * @package App\Entity\Traits
 *
 * @author  Codememory
 */
trait ValidTtlTrait
{
    /**
     * @return bool
     */
    public function isValidTtlByCreatedAt(): bool
    {
        $createdAt = $this->getCreatedAt()->getTimestamp();
        $now = (new DateTimeImmutable())->getTimestamp();

        return false === $now > $createdAt + $this->getTtl();
    }

    /**
     * @return bool
     */
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