<?php

namespace App\Service\Playlist;

use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaPlaylist;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\Playlist;

final class ExistMultimediaToPlaylist
{
    public function existToPlaylistDirectories(MultimediaMediaLibrary $multimediaMediaLibrary, Playlist $playlist): bool
    {
        foreach ($playlist->getDirectories() as $directory) {
            $exist = $directory
                ->getMultimedia()
                ->exists(static fn(int $key, MultimediaPlaylistDirectory $multimediaPlaylistDirectory) => $multimediaPlaylistDirectory->getMultimediaMediaLibrary()->isCompare($multimediaMediaLibrary));

            if ($exist) {
                return true;
            }
        }

        return false;
    }

    public function existToPlaylist(MultimediaMediaLibrary $multimediaMediaLibrary, Playlist $playlist): bool
    {
        return $playlist
            ->getMultimedia()
            ->exists(static fn(int $key, MultimediaPlaylist $multimediaPlaylist) => $multimediaPlaylist->getMultimediaMediaLibrary()->isCompare($multimediaMediaLibrary));
    }

    public function existToEntirePlaylist(MultimediaMediaLibrary $multimediaMediaLibrary, Playlist $playlist): bool
    {
        return $this->existToPlaylist($multimediaMediaLibrary, $playlist)
            || $this->existToPlaylistDirectories($multimediaMediaLibrary, $playlist);
    }

    public function existToEntirePlaylists(MultimediaMediaLibrary $multimediaMediaLibrary, Playlist &$inPlaylist): bool
    {
        foreach ($multimediaMediaLibrary->getMediaLibrary()->getPlaylists() as $playlist) {
            if ($this->existToEntirePlaylist($multimediaMediaLibrary, $playlist)) {
                $inPlaylist = $playlist;

                return true;
            }
        }

        return false;
    }
}