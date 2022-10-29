<?php

namespace App\Entity\Parser;

use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\Parser\ArtistPhotoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistPhotoRepository::class)]
#[ORM\Table('artist_photos')]
#[ORM\HasLifecycleCallbacks]
class ArtistPhoto
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: Artist::class, inversedBy: 'photos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artist $artist = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $link;

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
