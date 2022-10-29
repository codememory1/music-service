<?php

namespace App\Entity\Parser;

use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\Parser\MultimediaTagRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MultimediaTagRepository::class)]
#[ORM\Table('multimedia_tags')]
#[ORM\HasLifecycleCallbacks]
class MultimediaTag
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: Multimedia::class, inversedBy: 'tags')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Multimedia $multimedia = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $name = null;

    public function getMultimedia(): ?Multimedia
    {
        return $this->multimedia;
    }

    public function setMultimedia(?Multimedia $multimedia): self
    {
        $this->multimedia = $multimedia;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
