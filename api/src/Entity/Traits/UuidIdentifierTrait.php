<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Trait UuidIdentifierTrait.
 *
 * @package App\Entity\Traits
 *
 * @author  Codememory
 */
trait UuidIdentifierTrait
{
    #[ORM\Column(type: Types::STRING, length: 100, unique: true, nullable: true)]
    private ?string $uuid = null;

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function generateUuid(): self
    {
        if (null === $this->getUuid()) {
            $this->uuid = Uuid::uuid4()->toString() . '-' . Uuid::uuid4()->toString();
        }

        return $this;
    }
}