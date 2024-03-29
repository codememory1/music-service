<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\AlbumTypeEnum;
use App\Enum\PlatformCodeEnum;
use App\Infrastructure\Validator\Validator;
use App\Repository\AlbumTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AlbumTypeRepository::class)]
#[ORM\Table('album_types')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('key', 'entityExist@albumType', payload: [Validator::PPC => PlatformCodeEnum::ENTITY_FOUND])]
class AlbumType implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, options: [
        'comment' => 'Unique key for identification'
    ])]
    private ?string $key = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Type name as a translation key'
    ])]
    private ?string $titleTranslationKey = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Album::class, cascade: ['remove'])]
    private Collection $albums;

    #[Pure]
    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?AlbumTypeEnum $key): self
    {
        $this->key = $key?->name;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->titleTranslationKey;
    }

    public function setTitle(?string $titleTranslationKey): self
    {
        $this->titleTranslationKey = $titleTranslationKey;

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
            $album->setType($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getType() === $this) {
                $album->setType(null);
            }
        }

        return $this;
    }
}
