<?php

namespace App\Entity\Parser;

use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\Parser\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
#[ORM\Table('albums')]
#[ORM\HasLifecycleCallbacks]
class Album
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: Artist::class, inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artist $artist = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $imageLink = null;

    #[ORM\OneToMany(mappedBy: 'album', targetEntity: Multimedia::class, cascade: ['persist', 'remove'])]
    private Collection $multimedia;

    #[Pure]
    public function __construct()
    {
        $this->multimedia = new ArrayCollection();
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): self
    {
        $this->artist = $artist;

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

    public function getImageLink(): ?string
    {
        return $this->imageLink;
    }

    public function setImageLink(?string $imageLink): self
    {
        $this->imageLink = $imageLink;

        return $this;
    }

    /**
     * @return Collection<int, Multimedia>
     */
    public function getMultimedia(): Collection
    {
        return $this->multimedia;
    }

    public function addMultimedia(Multimedia $multimedia): self
    {
        if (!$this->multimedia->contains($multimedia)) {
            $this->multimedia[] = $multimedia;
            $multimedia->setAlbum($this);
        }

        return $this;
    }

    public function removeMultimedia(Multimedia $multimedia): self
    {
        if ($this->multimedia->removeElement($multimedia)) {
            // set the owning side to null (unless already changed)
            if ($multimedia->getAlbum() === $this) {
                $multimedia->setAlbum(null);
            }
        }

        return $this;
    }
}
