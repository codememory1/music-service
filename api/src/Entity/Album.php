<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\AlbumStatusEnum;
use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: AlbumType::class, inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AlbumType $type = null;

    #[ORM\Column(type: Types::STRING, length: 50, options: [
        'comment' => 'Album name'
    ])]
    private ?string $title = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Album description'
    ])]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, options: [
        'comment' => 'Album image as path to s3'
    ])]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'album', targetEntity: Multimedia::class)]
    private Collection $multimedia;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Album status from AlbumStatusEnum'
    ])]
    private ?string $status = null;

    public function __construct()
    {
        $this->setStatus(AlbumStatusEnum::SHOW);
        $this->multimedia = new ArrayCollection();
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
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     *
     * @return $this
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     *
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param null|string $image
     *
     * @return $this
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Multimedia>
     */
    public function getMultimedia(): Collection
    {
        return $this->multimedia;
    }

    /**
     * @param Multimedia $multimedia
     *
     * @return $this
     */
    public function addMultimedia(Multimedia $multimedia): self
    {
        if (!$this->multimedia->contains($multimedia)) {
            $this->multimedia[] = $multimedia;
            $multimedia->setAlbum($this);
        }

        return $this;
    }

    /**
     * @param Multimedia $multimedia
     *
     * @return $this
     */
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

    /**
     * @return null|string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param null|AlbumStatusEnum $status
     *
     * @return $this
     */
    public function setStatus(?AlbumStatusEnum $status): self
    {
        $this->status = $status?->name;

        return $this;
    }
}
