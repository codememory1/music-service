<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\UpdateNumberMultimediaMediaLibraryStatisticTrait;
use App\Repository\MultimediaPlaylistRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: MultimediaPlaylistRepository::class)]
#[ORM\Table('multimedia_playlist')]
#[ORM\HasLifecycleCallbacks]
final class MultimediaPlaylist implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use UpdateNumberMultimediaMediaLibraryStatisticTrait;
    use ComparisonTrait;

    #[ORM\ManyToOne(targetEntity: Playlist::class, inversedBy: 'multimedia')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Playlist $playlist = null;

    #[ORM\ManyToOne(targetEntity: MultimediaMediaLibrary::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?MultimediaMediaLibrary $multimediaMediaLibrary = null;

    public function getPlaylist(): ?Playlist
    {
        return $this->playlist;
    }

    public function setPlaylist(?Playlist $playlist): self
    {
        $this->playlist = $playlist;

        return $this;
    }

    public function getMultimediaMediaLibrary(): ?MultimediaMediaLibrary
    {
        return $this->multimediaMediaLibrary;
    }

    public function setMultimediaMediaLibrary(?MultimediaMediaLibrary $multimediaMediaLibrary): self
    {
        $this->multimediaMediaLibrary = $multimediaMediaLibrary;

        return $this;
    }

    #[Pure] 
    public function getMultimedia(): ?Multimedia
    {
        return $this->getMultimediaMediaLibrary()->getMultimedia();
    }

    #[Pure] 
    public function getMediaLibrary(): ?MediaLibrary
    {
        return $this->getMultimediaMediaLibrary()->getMediaLibrary();
    }
}
