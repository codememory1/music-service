<?php

namespace App\Entity\Traits;

use App\Entity\Interfaces\EntityInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait IdentifierTrait.
 *
 * @package App\Entity\Traits
 *
 * @author  Codememory
 */
trait IdentifierTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isInstance(EntityInterface $entity): bool
    {
        return $this->getId() === $entity->getId();
    }
}