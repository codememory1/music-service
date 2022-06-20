<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\AlbumTypeEnum;
use App\Enum\ResponseTypeEnum;
use App\Repository\AlbumTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class AlbumType.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: AlbumTypeRepository::class)]
#[ORM\Table('album_types')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('key', 'entityExist@albumType', payload: [ResponseTypeEnum::EXIST, 409])]
class AlbumType implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

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

    /**
     * @return null|string
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param null|AlbumTypeEnum $key
     *
     * @return $this
     */
    public function setKey(?AlbumTypeEnum $key): self
    {
        $this->key = $key?->name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->titleTranslationKey;
    }

    /**
     * @param null|string $titleTranslationKey
     *
     * @return $this
     */
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

    /**
     * @param Album $album
     *
     * @return $this
     */
    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
            $album->setType($this);
        }

        return $this;
    }

    /**
     * @param Album $album
     *
     * @return $this
     */
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
