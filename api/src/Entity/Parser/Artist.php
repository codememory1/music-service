<?php

namespace App\Entity\Parser;

use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\Parser\ArtistRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
#[ORM\Table('artists')]
#[ORM\HasLifecycleCallbacks]
class Artist
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $biography = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $dateBirth = null;

    #[ORM\OneToMany(mappedBy: 'artist', targetEntity: ArtistPhoto::class, cascade: ['persist', 'remove'])]
    private Collection $photos;

    #[ORM\OneToMany(mappedBy: 'artist', targetEntity: Multimedia::class, cascade: ['persist', 'remove'])]
    private Collection $multimedia;

    #[ORM\OneToMany(mappedBy: 'artist', targetEntity: Album::class, cascade: ['persist', 'remove'])]
    private Collection $albums;

    #[Pure]
    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->multimedia = new ArrayCollection();
        $this->albums = new ArrayCollection();
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

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    public function getDateBirth(): ?DateTimeInterface
    {
        return $this->dateBirth;
    }

    public function setDateBirth(?DateTimeInterface $dateBirth): self
    {
        $this->dateBirth = $dateBirth;

        return $this;
    }

    /**
     * @return Collection<int, ArtistPhoto>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(ArtistPhoto $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setArtist($this);
        }

        return $this;
    }

    public function removePhoto(ArtistPhoto $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getArtist() === $this) {
                $photo->setArtist(null);
            }
        }

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
            $multimedia->setArtist($this);
        }

        return $this;
    }

    public function removeMultimedia(Multimedia $multimedia): self
    {
        if ($this->multimedia->removeElement($multimedia)) {
            // set the owning side to null (unless already changed)
            if ($multimedia->getArtist() === $this) {
                $multimedia->setArtist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
            $album->setArtist($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getArtist() === $this) {
                $album->setArtist(null);
            }
        }

        return $this;
    }
}
