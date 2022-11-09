<?php

namespace App\Service\PlaylistDirectory;

use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\PlaylistDirectory;
use App\Exception\Http\EntityExistException;
use App\Infrastructure\Doctrine\Flusher;
use App\Repository\MultimediaPlaylistRepository;
use App\Service\Playlist\CheckExistMultimediaToPlaylistDirectories;

final class AddMultimediaToPlaylistDirectory
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly MultimediaPlaylistRepository $multimediaPlaylistRepository
    ) {
    }

    public function add(PlaylistDirectory $playlistDirectory, MultimediaMediaLibrary $multimediaMediaLibrary): MultimediaPlaylistDirectory
    {
        $multimediaPlaylist = $this->multimediaPlaylistRepository->findOneBy([
            'playlist' => $playlistDirectory->getPlaylist(),
            'multimediaMediaLibrary' => $multimediaMediaLibrary
        ]);
        $checkExistMultimediaToPlaylistDirectories = new CheckExistMultimediaToPlaylistDirectories();

        $checkExistMultimediaToPlaylistDirectories->throwIfExist(
            $playlistDirectory->getPlaylist()->getDirectories(),
            $multimediaMediaLibrary
        );

        if (null !== $multimediaPlaylist) {
            throw EntityExistException::multimediaPlaylist();
        }

        $multimediaPlaylistDirectory = new MultimediaPlaylistDirectory();

        $multimediaPlaylistDirectory->setMultimediaMediaLibrary($multimediaMediaLibrary);
        $multimediaPlaylistDirectory->setPlaylistDirectory($playlistDirectory);

        $this->flusher->save($multimediaPlaylistDirectory);

        return $multimediaPlaylistDirectory;
    }
}