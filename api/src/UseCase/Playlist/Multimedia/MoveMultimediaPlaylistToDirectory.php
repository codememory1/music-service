<?php

namespace App\UseCase\Playlist\Multimedia;

use App\Entity\MultimediaPlaylist;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\PlaylistDirectory;
use App\Infrastructure\Doctrine\Flusher;

final class MoveMultimediaPlaylistToDirectory
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function process(MultimediaPlaylist $multimediaPlaylist, PlaylistDirectory $toDirectory): MultimediaPlaylist
    {
        $multimediaPlaylistDirectory = new MultimediaPlaylistDirectory();

        $multimediaPlaylistDirectory->setMultimediaMediaLibrary($multimediaPlaylist->getMultimediaMediaLibrary());

        $toDirectory->addMultimedia($multimediaPlaylistDirectory);

        $this->flusher->save();

        return $multimediaPlaylist;
    }
}