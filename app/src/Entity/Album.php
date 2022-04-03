<?php

namespace App\Entity;

use App\Interfaces\EntityInterface;
use App\Repository\AlbumRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * Class Album.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: AlbumRepository::class)]
#[ORM\Table('albums')]
#[ORM\HasLifecycleCallbacks]
class Album implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    /**
     * @var null|AlbumType
     */
    #[ORM\ManyToOne(targetEntity: AlbumType::class, inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AlbumType $type = null;

    /**
     * @var null|AlbumCategory
     */
    #[ORM\ManyToOne(targetEntity: AlbumCategory::class, inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AlbumCategory $category = null;

    /**
     * @var null|User
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Album name'
    ])]
    private ?string $title = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::TEXT, options: [
        'comment' => 'Link to album photo'
    ])]
    private ?string $photo = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::JSON, nullable: true, options: [
        'comment' => 'Album tags'
    ])]
    private ?string $tags = null;

    /**
     * @var null|int
     */
    #[ORM\Column(type: Types::INTEGER, nullable: true, options: [
        'comment' => 'Number of full plays',
        'default' => 0
    ])]
    private ?int $auditions = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'album', targetEntity: Music::class, cascade: ['persist', 'remove'])]
    private Collection $musics;

    #[Pure]
    public function __construct()
    {
        $this->musics = new ArrayCollection();
    }

    /**
     * @return null|AlbumType
     */
    public function getType(): ?AlbumType
    {
        return $this->type;
    }

    /**
     * @param null|AlbumType $type
     *
     * @return $this
     */
    public function setType(?AlbumType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return null|AlbumCategory
     */
    public function getCategory(): ?AlbumCategory
    {
        return $this->category;
    }

    /**
     * @param null|AlbumCategory $category
     *
     * @return $this
     */
    public function setCategory(?AlbumCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param null|User $user
     *
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     *
     * @return $this
     */
    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTags(): ?string
    {
        return json_decode($this->tags ?? '', true);
    }

    /**
     * @param array $tags
     *
     * @return $this
     */
    public function setTags(array $tags): self
    {
        $this->tags = json_encode($tags);

        return $this;
    }

    /**
     * @return null|int
     */
    public function getAuditions(): ?int
    {
        return $this->auditions;
    }

    /**
     * @param int $auditions
     *
     * @return $this
     */
    public function setAuditions(int $auditions): self
    {
        $this->auditions = $auditions;

        return $this;
    }
}
