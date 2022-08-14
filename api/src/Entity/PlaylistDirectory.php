<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\PlaylistDirectoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: PlaylistDirectoryRepository::class)]
#[ORM\Table('playlist_directories')]
#[ORM\HasLifecycleCallbacks]
final class PlaylistDirectory implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\Column(type: Types::STRING, length: 50, options: [
        'comment' => 'Directory name'
    ])]
    private ?string $title = null;

    #[ORM\ManyToOne(targetEntity: Playlist::class, inversedBy: 'directories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Playlist $playlist = null;

    #[ORM\OneToMany(mappedBy: 'playlistDirectory', targetEntity: MultimediaPlaylistDirectory::class, cascade: ['persist', 'remove'])]
    private Collection $multimedia;

    #[Pure]
    public function __construct()
    {
        $this->multimedia = new ArrayCollection();
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

    public function getPlaylist(): ?Playlist
    {
        return $this->playlist;
    }

    public function setPlaylist(?Playlist $playlist): self
    {
        $this->playlist = $playlist;

        return $this;
    }

    /**
     * @return Collection<int, MultimediaPlaylistDirectory>
     */
    public function getMultimedia(): Collection
    {
        return $this->multimedia;
    }

    public function addMultimedia(MultimediaPlaylistDirectory $multimedia): self
    {
        if (!$this->multimedia->contains($multimedia)) {
            $this->multimedia[] = $multimedia;
            $multimedia->setPlaylistDirectory($this);
        }

        return $this;
    }

    public function removeMultimedia(MultimediaPlaylistDirectory $multimedia): self
    {
        if ($this->multimedia->removeElement($multimedia)) {
            // set the owning side to null (unless already changed)
            if ($multimedia->getPlaylistDirectory() === $this) {
                $multimedia->setPlaylistDirectory(null);
            }
        }

        return $this;
    }
}
