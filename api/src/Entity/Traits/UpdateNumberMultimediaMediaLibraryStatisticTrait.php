<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait UpdateNumberMultimediaMediaLibraryStatisticTrait
{
    #[ORM\PrePersist]
    final public function addNumberMultimediaToMediaLibraryStatistic(): void
    {
        $statistic = $this->getMediaLibrary()->getStatistic();

        if ($this->getMultimedia()->isTrack()) {
            $statistic->setNumberOfTracks($statistic->getNumberOfTracks() + 1);
        }

        if ($this->getMultimedia()->isClip()) {
            $statistic->setNumberOfClips($statistic->getNumberOfClips() + 1);
        }
    }

    #[ORM\PreRemove]
    final public function removeNumberMultimediaToMediaLibraryStatistic(): void
    {
        $statistic = $this->getMediaLibrary()->getStatistic();

        if ($this->getMultimedia()->isTrack()) {
            $statistic->setNumberOfTracks($statistic->getNumberOfTracks() - 1);
        }

        if ($this->getMultimedia()->isClip()) {
            $statistic->setNumberOfClips($statistic->getNumberOfClips() - 1);
        }
    }
}