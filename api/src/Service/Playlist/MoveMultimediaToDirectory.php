<?php

namespace App\Service\Playlist;

use App\Entity\MultimediaPlaylist;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\PlaylistDirectory;
use App\Service\FlusherService;

class MoveMultimediaToDirectory
{
    public function __construct(
        private readonly FlusherService $flusher
    ) {
    }

    public function move(MultimediaPlaylist $multimediaPlaylist, PlaylistDirectory $toDirectory): MultimediaPlaylist
    {
        $multimediaPlaylistDirectory = new MultimediaPlaylistDirectory();

        $multimediaPlaylistDirectory->setMultimediaMediaLibrary($multimediaPlaylist->getMultimediaMediaLibrary());

        $toDirectory->addMultimedia($multimediaPlaylistDirectory);

        $this->flusher->save($multimediaPlaylist);

        return $multimediaPlaylist;
    }
}