<?php

namespace App\Entity;

use App\Interfaces\EntityInterface;
use App\Repository\MediaLibraryRepository;
use App\Traits\Entity\IdentifierTrait;
use App\Traits\Entity\TimestampTrait;
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

    /**
     * @var null|User
     */
    #[ORM\OneToOne(inversedBy: 'mediaLibrary', targetEntity: User::class)]
    #[ORM\JoinColumn(unique: true, nullable: false)]
    private ?User $user = null;

    /**
     * @var null|int
     */
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $status = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'mediaLibrary', targetEntity: MediaLibraryMusic::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $mediaLibraryMusics;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'mediaLibrary', targetEntity: Playlist::class, cascade: ['persist', 'remove'])]
    private Collection $playlists;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'mediaLibrary', targetEntity: MediaLibraryEvent::class, cascade: ['persist', 'remove'])]
    private Collection $mediaLibraryEvents;

    #[Pure]
    public function __construct()
    {
        $this->playlists = new ArrayCollection();
        $this->mediaLibraryEvents = new ArrayCollection();
    }

    /**
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return $this
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getMediaLibraryMusics(): Collection
    {
        return $this->mediaLibraryMusics;
    }

    /**
     * @param MediaLibraryMusic $mediaLibraryMusic
     *
     * @return $this
     */
    public function addMusicToMediaLibrary(MediaLibraryMusic $mediaLibraryMusic): self
    {
        if (!$this->mediaLibraryMusics->contains($mediaLibraryMusic)) {
            $this->mediaLibraryMusics[] = $mediaLibraryMusic;
            $mediaLibraryMusic->setMediaLibrary($this);
        }

        return $this;
    }

    /**
     * @param MediaLibraryMusic $mediaLibraryMusic
     *
     * @return $this
     */
    public function removeMusicFromMediaLibrary(MediaLibraryMusic $mediaLibraryMusic): self
    {
        if ($this->mediaLibraryMusics->removeElement($mediaLibraryMusic)) {
            // set the owning side to null (unless already changed)
            if ($mediaLibraryMusic->getMediaLibrary() === $this) {
                $mediaLibraryMusic->setMediaLibrary(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    /**
     * @param Playlist $playlist
     *
     * @return $this
     */
    public function addPlaylist(Playlist $playlist): self
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists[] = $playlist;
            $playlist->setMediaLibrary($this);
        }

        return $this;
    }

    /**
     * @param Playlist $playlist
     *
     * @return $this
     */
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
     * @return Collection
     */
    public function getEvents(): Collection
    {
        return $this->mediaLibraryEvents;
    }

    /**
     * @param MediaLibraryEvent $mediaLibraryEvent
     *
     * @return $this
     */
    public function addEvent(MediaLibraryEvent $mediaLibraryEvent): self
    {
        if (!$this->mediaLibraryEvents->contains($mediaLibraryEvent)) {
            $this->mediaLibraryEvents[] = $mediaLibraryEvent;
            $mediaLibraryEvent->setMediaLibrary($this);
        }

        return $this;
    }

    /**
     * @param MediaLibraryEvent $mediaLibraryEvent
     *
     * @return $this
     */
    public function removeEvent(MediaLibraryEvent $mediaLibraryEvent): self
    {
        if ($this->mediaLibraryEvents->removeElement($mediaLibraryEvent)) {
            // set the owning side to null (unless already changed)
            if ($mediaLibraryEvent->getMediaLibrary() === $this) {
                $mediaLibraryEvent->setMediaLibrary(null);
            }
        }

        return $this;
    }
}
