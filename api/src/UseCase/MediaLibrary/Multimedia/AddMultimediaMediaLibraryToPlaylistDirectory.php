<?php

namespace App\UseCase\MediaLibrary\Multimedia;

use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\Playlist;
use App\Entity\PlaylistDirectory;
use App\Exception\Http\EntityExistException;
use App\Infrastructure\Doctrine\Flusher;
use App\Repository\MultimediaPlaylistRepository;
use App\Service\Playlist\ExistMultimediaToPlaylist;

final class AddMultimediaMediaLibraryToPlaylistDirectory
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly MultimediaPlaylistRepository $multimediaPlaylistRepository,
        private readonly ExistMultimediaToPlaylist $existMultimediaToPlaylist
    ) {
    }

    public function process(MultimediaMediaLibrary $multimediaMediaLibrary, PlaylistDirectory $playlistDirectory): MultimediaPlaylistDirectory
    {
        $multimediaPlaylist = $this->multimediaPlaylistRepository->findOneBy([
            'playlist' => $playlistDirectory->getPlaylist(),
            'multimediaMediaLibrary' => $multimediaMediaLibrary
        ]);

        /** @var Playlist $in */
        if ($this->existMultimediaToPlaylist->existToEntirePlaylists($multimediaMediaLibrary, $in)) {
            throw EntityExistException::multimediaPlaylist(['playlist' => $in->getTitle()]);
        }

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