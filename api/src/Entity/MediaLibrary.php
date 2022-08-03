<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\MediaLibraryStatusEnum;
use App\Enum\MultimediaTypeEnum;
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

    #[ORM\OneToMany(mappedBy: 'mediaLibrary', targetEntity: Playlist::class, cascade: ['persist', 'remove'])]
    private Collection $playlists;

    #[ORM\OneToMany(mappedBy: 'mediaLibrary', targetEntity: MediaLibraryEvent::class, cascade: ['persist', 'remove'])]
    private Collection $events;

    #[Pure]
    public function __construct()
    {
        $this->multimedia = new ArrayCollection();
        $this->playlists = new ArrayCollection();
        $this->events = new ArrayCollection();
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

    public function setHideStatus(): self
    {
        $this->setStatus(MediaLibraryStatusEnum::HIDE);

        return $this;
    }

    public function isHide(): bool
    {
        return $this->getStatus() === MediaLibraryStatusEnum::HIDE->name;
    }

    public function setShowStatus(): self
    {
        $this->setStatus(MediaLibraryStatusEnum::SHOW);

        return $this;
    }

    public function isShow(): bool
    {
        return $this->getStatus() === MediaLibraryStatusEnum::SHOW->name;
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

    public function isMultimediaBelongsToMediaLibrary(MultimediaMediaLibrary $multimedia): bool
    {
        return $multimedia->getMediaLibrary()->getId() === $this->getId();
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

    /**
     * @return Collection<int, MediaLibraryEvent>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(MediaLibraryEvent $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setMediaLibrary($this);
        }

        return $this;
    }

    public function removeEvent(MediaLibraryEvent $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getMediaLibrary() === $this) {
                $event->setMediaLibrary(null);
            }
        }

        return $this;
    }

    public function getCountTracks(): int
    {
        return $this->getCountMultimedia(MultimediaTypeEnum::TRACK);
    }

    public function getCountClips(): int
    {
        return $this->getCountMultimedia(MultimediaTypeEnum::CLIP);
    }

    public function getCountPlaylists(): int
    {
        return $this->getPlaylists()->count();
    }

    private function getCountMultimedia(MultimediaTypeEnum $type): int
    {
        $count = $this
            ->getMultimedia()
            ->filter(static fn(MultimediaMediaLibrary $multimediaMediaLibrary) => $multimediaMediaLibrary->getMultimedia()->getType() === $type->name)->count();

        $this
            ->getPlaylists()
            ->map(static function(Playlist $playlist) use (&$count, $type) {
                $count += $playlist
                    ->getMultimedia()
                    ->filter(static fn(Multimedia $multimedia) => $multimedia->getType() === $type->name)->count();

                $playlist
                    ->getDirectories()
                    ->map(static function(PlaylistDirectory $playlistDirectory) use (&$count, $type): void {
                        $count += $playlistDirectory
                            ->getMultimedia()
                            ->filter(static fn(Multimedia $multimedia) => $multimedia->getType() === $type->name)->count();
                    });

                return $playlist;
            });

        return $count;
    }
}
