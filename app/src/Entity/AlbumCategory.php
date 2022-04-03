<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Repository\AlbumCategoryRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class AlbumCategory.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: AlbumCategoryRepository::class)]
#[ORM\Table('album_categories')]
#[UniqueEntity(
    'titleTranslationKey',
    'albumCategory@exist',
    payload: ApiResponseTypeEnum::CHECK_EXIST
)]
#[ORM\HasLifecycleCallbacks]
class AlbumCategory implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 255, unique: true, options: [
        'comment' => 'Album category translation key'
    ])]
    private ?string $titleTranslationKey;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Album::class)]
    private Collection $albums;

    #[Pure]
    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }

    /**
     * @return null|string
     */
    public function getTitleTranslationKey(): ?string
    {
        return $this->titleTranslationKey;
    }

    /**
     * @param string $titleTranslationKey
     *
     * @return $this
     */
    public function setTitleTranslationKey(string $titleTranslationKey): self
    {
        $this->titleTranslationKey = $titleTranslationKey;

        return $this;
    }

    /**
     * @return Collection
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
            $album->setCategory($this);
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
            if ($album->getCategory() === $this) {
                $album->setCategory(null);
            }
        }

        return $this;
    }
}
