<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\MediaLibraryStatusEnum;
use App\Repository\MediaLibraryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: MediaLibraryRepository::class)]
#[ORM\Table('media_libraries')]
#[ORM\HasLifecycleCallbacks]
final class MediaLibrary implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

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

    #[ORM\OneToOne(mappedBy: 'mediaLibrary', targetEntity: MediaLibraryStatistic::class, cascade: ['persist', 'remove'])]
    private ?MediaLibraryStatistic $statistic = null;

    public function __construct()
    {
        $this->multimedia = new ArrayCollection();
        $this->playlists = new ArrayCollection();
        $this->events = new ArrayCollection();

        $this->initStatistic();
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

    #[Pure]
    public function isHide(): bool
    {
        return $this->getStatus() === MediaLibraryStatusEnum::HIDE->name;
    }

    public function setShowStatus(): self
    {
        $this->setStatus(MediaLibraryStatusEnum::SHOW);

        return $this;
    }

    #[Pure]
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
        return $multimedia->getMediaLibrary()->isCompare($this);
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

    public function getStatistic(): ?MediaLibraryStatistic
    {
        return $this->statistic;
    }

    public function setStatistic(MediaLibraryStatistic $statistic): self
    {
        // set the owning side of the relation if necessary
        if ($statistic->getMediaLibrary() !== $this) {
            $statistic->setMediaLibrary($this);
        }

        $this->statistic = $statistic;

        return $this;
    }

    private function initStatistic(): void
    {
        if (null === $this->getStatistic()) {
            $this->setStatistic(new MediaLibraryStatistic());
        }
    }
}
