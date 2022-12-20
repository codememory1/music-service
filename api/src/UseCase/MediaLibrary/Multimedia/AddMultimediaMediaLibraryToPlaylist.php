<?php

namespace App\UseCase\MediaLibrary\Multimedia;

use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaPlaylist;
use App\Entity\Playlist;
use App\Exception\Http\EntityExistException;
use App\Infrastructure\Doctrine\Flusher;
use App\Service\Playlist\ExistMultimediaToPlaylist;

final class AddMultimediaMediaLibraryToPlaylist
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly ExistMultimediaToPlaylist $existMultimediaToPlaylist
    ) {
    }

    public function process(MultimediaMediaLibrary $multimediaMediaLibrary, Playlist $playlist): MultimediaMediaLibrary
    {
        if ($this->existMultimediaToPlaylist->existToEntirePlaylist($multimediaMediaLibrary, $playlist)) {
            throw EntityExistException::multimediaPlaylist();
        }

        $multimediaPlaylist = new MultimediaPlaylist();

        $multimediaPlaylist->setMultimediaMediaLibrary($multimediaMediaLibrary);

        $playlist->addMultimedia($multimediaPlaylist);

        $this->flusher->save();

        return $multimediaMediaLibrary;
    }
}