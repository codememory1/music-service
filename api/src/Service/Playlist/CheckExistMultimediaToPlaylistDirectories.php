<?php

namespace App\Service\Playlist;

use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\PlaylistDirectory;
use App\Exception\Http\EntityExistException;
use Doctrine\Common\Collections\Collection;

final class CheckExistMultimediaToPlaylistDirectories
{
    public function throwIfExist(Collection $directories, MultimediaMediaLibrary $multimediaMediaLibrary): void
    {
        /** @var PlaylistDirectory $directory */
        foreach ($directories as $directory) {
            $multimediaPlaylistDirectory = $directory->getMultimedia();
            $isExistMultimediaToDirectory = $multimediaPlaylistDirectory->exists(static fn(int $key, MultimediaPlaylistDirectory $multimediaPlaylistDirectory) => $multimediaPlaylistDirectory->getMultimediaMediaLibrary()->getId() === $multimediaMediaLibrary->getId());

            if ($isExistMultimediaToDirectory) {
                throw EntityExistException::multimediaPlaylist();
            }
        }
    }
}