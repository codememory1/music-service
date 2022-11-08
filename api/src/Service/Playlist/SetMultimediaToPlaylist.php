<?php

namespace App\Service\Playlist;

use App\Entity\MediaLibrary;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\Playlist;
use App\Exception\Http\EntityNotFoundException;
use Doctrine\Common\Collections\Criteria;

class SetMultimediaToPlaylist
{
    public function set(array $multimediaMediaLibrary, Playlist $playlist): void
    {
        $checkExistMultimediaToPlaylistDirectoriesService = new CheckExistMultimediaToPlaylistDirectories();
        $multimediaMediaLibraryCollection = [];

        foreach (array_unique($multimediaMediaLibrary) as $multimediaMediaLibraryId) {
            $finedMultimediaMediaLibrary = $this->getMultimediaMediaLibrary($playlist->getMediaLibrary(), $multimediaMediaLibraryId);

            if (false === $finedMultimediaMediaLibrary) {
                throw EntityNotFoundException::multimedia();
            }

            $checkExistMultimediaToPlaylistDirectoriesService->throwIfExist(
                $playlist->getDirectories(),
                $finedMultimediaMediaLibrary
            );

            $multimediaMediaLibraryCollection[] = $finedMultimediaMediaLibrary;
        }

        $playlist->setMultimedia($multimediaMediaLibraryCollection);
    }

    private function getMultimediaMediaLibrary(MediaLibrary $mediaLibrary, int $multimediaMediaLibraryId): bool|MultimediaMediaLibrary
    {
        $criteria = Criteria::create()->andWhere(
            Criteria::expr()->eq('id', $multimediaMediaLibraryId)
        );
        $criteria->setMaxResults(1);

        return $mediaLibrary->getMultimedia()->matching($criteria)->first();
    }
}