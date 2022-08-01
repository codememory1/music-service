<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Interfaces\EntityS3SettingInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\UuidIdentifierTrait;
use App\Enum\AlbumStatusEnum;
use App\Enum\EntityS3SettingEnum;
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
class Album implements EntityInterface, EntityS3SettingInterface
{
    use IdentifierTrait;
    use UuidIdentifierTrait;
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

    #[ORM\Column(type: Types::TEXT, nullable: true, options: [
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
        $this->generateUuid();
        $this->setUnpublishStatus();

        $this->multimedia = new ArrayCollection();
    }

    public function getFolderName(): EntityS3SettingEnum
    {
        return EntityS3SettingEnum::ALBUM;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getType(): ?AlbumType
    {
        return $this->type;
    }

    public function setType(?AlbumType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?AlbumStatusEnum $status): self
    {
        $this->status = $status?->name;

        return $this;
    }

    public function setPublishStatus(): self
    {
        $this->setStatus(AlbumStatusEnum::PUBLISHED);

        return $this;
    }

    public function isPublished(): bool
    {
        return $this->getStatus() === AlbumStatusEnum::PUBLISHED->name;
    }

    public function setUnpublishStatus(): self
    {
        $this->setStatus(AlbumStatusEnum::UNPUBLISHED);

        return $this;
    }

    public function isUnpublished(): bool
    {
        return $this->getStatus() === AlbumStatusEnum::UNPUBLISHED->name;
    }
}
