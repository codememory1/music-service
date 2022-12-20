<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\MediaLibraryStatisticRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaLibraryStatisticRepository::class)]
#[ORM\Table('media_library_statistics')]
#[ORM\HasLifecycleCallbacks]
class MediaLibraryStatistic implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\OneToOne(inversedBy: 'statistic', targetEntity: MediaLibrary::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?MediaLibrary $mediaLibrary = null;

    #[ORM\Column(type: Types::INTEGER, options: [
        'comment' => 'Total number of tracks in the library'
    ])]
    private int $numberOfTracks = 0;

    #[ORM\Column(type: Types::INTEGER, options: [
        'comment' => 'Total number of clips in the library'
    ])]
    private int $numberOfClips = 0;

    #[ORM\Column(type: Types::INTEGER, options: [
        'comment' => 'Number of playlists in the library'
    ])]
    private int $numberOfPlaylists = 0;

    public function getMediaLibrary(): ?MediaLibrary
    {
        return $this->mediaLibrary;
    }

    public function setMediaLibrary(MediaLibrary $mediaLibrary): self
    {
        $this->mediaLibrary = $mediaLibrary;

        return $this;
    }

    public function getNumberOfTracks(): ?int
    {
        return $this->numberOfTracks;
    }

    public function setNumberOfTracks(int $numberOfTracks): self
    {
        $this->numberOfTracks = $numberOfTracks;

        return $this;
    }

    public function getNumberOfClips(): ?int
    {
        return $this->numberOfClips;
    }

    public function setNumberOfClips(int $numberOfClips): self
    {
        $this->numberOfClips = $numberOfClips;

        return $this;
    }

    public function getNumberOfPlaylists(): ?int
    {
        return $this->numberOfPlaylists;
    }

    public function setNumberOfPlaylists(int $numberOfPlaylists): self
    {
        $this->numberOfPlaylists = $numberOfPlaylists;

        return $this;
    }

    public function getLastAddedMultimedia(): ?MultimediaMediaLibrary
    {
        $lastMultimedia = $this->getMediaLibrary()->getMultimedia()->last();

        if (false === $lastMultimedia) {
            return null;
        }

        return $lastMultimedia;
    }
}
