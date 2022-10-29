<?php

namespace App\Entity\Parser;

use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\Parser\MultimediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: MultimediaRepository::class)]
#[ORM\Table('multimedia')]
#[ORM\HasLifecycleCallbacks]
class Multimedia
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: Artist::class, inversedBy: 'multimedia')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artist $artist = null;

    #[ORM\ManyToOne(targetEntity: Album::class, inversedBy: 'multimedia')]
    private ?Album $album = null;

    #[ORM\Column(type: Types::STRING, length: 10)]
    private ?string $type = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $isObsceneWords = false;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $imageLink = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $linkToMedia = null;

    #[ORM\OneToMany(mappedBy: 'multimedia', targetEntity: MultimediaTag::class, cascade: ['persist', 'remove'])]
    private Collection $tags;

    #[Pure]
    public function __construct()
    {
        $this->tags = new ArrayCollection();
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

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function isIsObsceneWords(): ?bool
    {
        return $this->isObsceneWords;
    }

    public function setIsObsceneWords(bool $isObsceneWords): self
    {
        $this->isObsceneWords = $isObsceneWords;

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

    public function getLinkToMedia(): ?string
    {
        return $this->linkToMedia;
    }

    public function setLinkToMedia(?string $linkToMedia): self
    {
        $this->linkToMedia = $linkToMedia;

        return $this;
    }

    /**
     * @return Collection<int, MultimediaTag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(MultimediaTag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->setMultimedia($this);
        }

        return $this;
    }

    public function removeTag(MultimediaTag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getMultimedia() === $this) {
                $tag->setMultimedia(null);
            }
        }

        return $this;
    }
}
