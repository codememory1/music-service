<?php

namespace App\Entity;

use App\Repository\ContinentRepository;
use Codememory\ApiBundle\Entity\Interfaces\EntityInterface;
use Codememory\ApiBundle\Entity\Traits\IdentifierTrait;
use Codememory\ApiBundle\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContinentRepository::class)]
#[ORM\Table('continents')]
#[ORM\HasLifecycleCallbacks]
class Continent implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
