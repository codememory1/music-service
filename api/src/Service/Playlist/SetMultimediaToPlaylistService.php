<?php

namespace App\Service\Playlist;

use App\Entity\MediaLibrary;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\Playlist;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use Doctrine\Common\Collections\Criteria;

/**
 * Class SetMultimediaToPlaylistService.
 *
 * @package App\Service\Playlist
 *
 * @author  Codememory
 */
class SetMultimediaToPlaylistService
{
    public function set(array $multimediaMediaLibrary, Playlist $playlist): void
    {
        $checkExistMultimediaToPlaylistDirectoriesService = new CheckExistMultimediaToPlaylistDirectoriesService();
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

    private function getMultimediaMediaLibrary(MediaLibrary $mediaLibrary, int $id): bool|MultimediaMediaLibrary
    {
        $criteria = Criteria::create()->andWhere(
            Criteria::expr()->eq('id', $id)
        );
        $criteria->setMaxResults(1);

        return $mediaLibrary->getMultimedia()->matching($criteria)->first();
    }
}