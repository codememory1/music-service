<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\UpdateNumberMultimediaMediaLibraryStatisticTrait;
use App\Repository\MultimediaPlaylistDirectoryRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: MultimediaPlaylistDirectoryRepository::class)]
#[ORM\Table('multimedia_playlist_directory')]
#[ORM\HasLifecycleCallbacks]
final class MultimediaPlaylistDirectory implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use UpdateNumberMultimediaMediaLibraryStatisticTrait;
    use ComparisonTrait;

    #[ORM\ManyToOne(targetEntity: PlaylistDirectory::class, inversedBy: 'multimedia')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PlaylistDirectory $playlistDirectory = null;

    #[ORM\ManyToOne(targetEntity: MultimediaMediaLibrary::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?MultimediaMediaLibrary $multimediaMediaLibrary = null;

    public function getPlaylistDirectory(): ?PlaylistDirectory
    {
        return $this->playlistDirectory;
    }

    public function setPlaylistDirectory(?PlaylistDirectory $playlistDirectory): self
    {
        $this->playlistDirectory = $playlistDirectory;

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
