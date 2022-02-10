<?php

namespace App\Trait\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Trait UpdatedAtTrait
 *
 * @package App\Trait\Entity
 *
 * @author  Codememory
 */
trait UpdatedAtTrait
{

    /**
     * @var DateTimeImmutable|null
     */
    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    /**
     * @return void
     */
    #[ORM\PreUpdate]
    public function setUpdatedAt(): void
    {

        $this->updatedAt = new DateTimeImmutable();

    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getUpdatedAt(): ?DateTimeImmutable
    {

        return $this->updatedAt;

    }

}