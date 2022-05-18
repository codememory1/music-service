<?php

namespace App\Entity\Traits;

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
    /**
     * @var null|int
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    /**
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}