<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\PlaylistStatusEnum;
use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * Class Playlist.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
#[ORM\Table('playlists')]
#[ORM\HasLifecycleCallbacks]
class Playlist implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: MediaLibrary::class, inversedBy: 'playlists')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MediaLibrary $mediaLibrary = null;

    #[ORM\Column(type: Types::STRING, length: 50, options: [
        'comment' => 'Playlist name'
    ])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: [
        'comment' => 'Playlist image path'
    ])]
    private ?string $image = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Playlist status from PlaylistStatusEnum'
    ])]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'playlist', targetEntity: MultimediaPlaylist::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $multimedia;

    #[ORM\OneToMany(mappedBy: 'playlist', targetEntity: PlaylistDirectory::class)]
    private Collection $directories;

    public function __construct()
    {
        $this->setStatus(PlaylistStatusEnum::SHOW);

        $this->multimedia = new ArrayCollection();
        $this->directories = new ArrayCollection();
    }

    public function getMediaLibrary(): ?MediaLibrary
    {
        return $this->mediaLibrary;
    }

    public function setMediaLibrary(?MediaLibrary $mediaLibrary): self
    {
        $this->mediaLibrary = $mediaLibrary;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?PlaylistStatusEnum $status): self
    {
        $this->status = $status?->name;

        return $this;
    }

    public function setHideStatus(): self
    {
        $this->setStatus(PlaylistStatusEnum::HIDE);

        return $this;
    }

    #[Pure]
    public function isHide(): bool
    {
        return $this->getStatus() === PlaylistStatusEnum::HIDE->name;
    }

    public function setShowStatus(): self
    {
        $this->setStatus(PlaylistStatusEnum::SHOW);

        return $this;
    }

    #[Pure]
    public function isShow(): bool
    {
        return $this->getStatus() === PlaylistStatusEnum::SHOW->name;
    }

    /**
     * @return Collection<int, MultimediaPlaylist>
     */
    public function getMultimedia(): Collection
    {
        return $this->multimedia;
    }

    /**
     * @param array<MultimediaMediaLibrary> $multimedia
     */
    public function setMultimedia(array $multimedia): self
    {
        foreach ($multimedia as $multimediaEntity) {
            $multimediaPlayList = new MultimediaPlaylist();

            $multimediaPlayList->setPlaylist($this);
            $multimediaPlayList->setMultimediaMediaLibrary($multimediaEntity);

            $this->multimedia[] = $multimediaPlayList;
        }

        return $this;
    }

    public function addMultimedia(MultimediaPlaylist $multimedia): self
    {
        if (!$this->multimedia->contains($multimedia)) {
            $this->multimedia[] = $multimedia;
            $multimedia->setPlaylist($this);
        }

        return $this;
    }

    public function removeMultimedia(MultimediaPlaylist $multimedia): self
    {
        if ($this->multimedia->removeElement($multimedia)) {
            // set the owning side to null (unless already changed)
            if ($multimedia->getPlaylist() === $this) {
                $multimedia->setPlaylist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlaylistDirectory>
     */
    public function getDirectories(): Collection
    {
        return $this->directories;
    }

    public function addDirectory(PlaylistDirectory $directory): self
    {
        if (!$this->directories->contains($directory)) {
            $this->directories[] = $directory;
            $directory->setPlaylist($this);
        }

        return $this;
    }

    public function removeDirectory(PlaylistDirectory $directory): self
    {
        if ($this->directories->removeElement($directory)) {
            // set the owning side to null (unless already changed)
            if ($directory->getPlaylist() === $this) {
                $directory->setPlaylist(null);
            }
        }

        return $this;
    }
}
