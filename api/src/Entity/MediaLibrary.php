<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\MediaLibraryStatusEnum;
use App\Repository\MediaLibraryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * Class MediaLibrary.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MediaLibraryRepository::class)]
#[ORM\Table('media_libraries')]
#[ORM\HasLifecycleCallbacks]
class MediaLibrary implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;

    #[ORM\OneToOne(inversedBy: 'mediaLibrary', targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Media library status from MediaLibraryStatusEnum'
    ])]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'mediaLibrary', targetEntity: MultimediaMediaLibrary::class, cascade: ['persist'])]
    private Collection $multimedia;

    #[ORM\OneToMany(mappedBy: 'mediaLibrary', targetEntity: Playlist::class)]
    private Collection $playlists;

    #[Pure]
    public function __construct()
    {
        $this->multimedia = new ArrayCollection();
        $this->playlists = new ArrayCollection();
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?MediaLibraryStatusEnum $status): self
    {
        $this->status = $status?->name;

        return $this;
    }

    /**
     * @return ArrayCollection|Collection<int, MultimediaMediaLibrary>
     */
    public function getMultimedia(): Collection
    {
        return $this->multimedia;
    }

    public function addMultimedia(MultimediaMediaLibrary $multimedia): self
    {
        if (!$this->multimedia->contains($multimedia)) {
            $this->multimedia[] = $multimedia;
            $multimedia->setMediaLibrary($this);
        }

        return $this;
    }

    public function removeMultimedia(MultimediaMediaLibrary $multimedia): self
    {
        if ($this->multimedia->removeElement($multimedia)) {
            // set the owning side to null (unless already changed)
            if ($multimedia->getMediaLibrary() === $this) {
                $multimedia->setMediaLibrary(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Playlist>
     */
    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist): self
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists[] = $playlist;
            $playlist->setMediaLibrary($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): self
    {
        if ($this->playlists->removeElement($playlist)) {
            // set the owning side to null (unless already changed)
            if ($playlist->getMediaLibrary() === $this) {
                $playlist->setMediaLibrary(null);
            }
        }

        return $this;
    }
}
