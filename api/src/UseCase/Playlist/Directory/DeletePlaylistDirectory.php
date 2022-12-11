<?php

namespace App\UseCase\Playlist\Directory;

use App\Entity\PlaylistDirectory;
use App\Infrastructure\Doctrine\Flusher;

final class DeletePlaylistDirectory
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function process(PlaylistDirectory $playlistDirectory): PlaylistDirectory
    {
        $this->flusher->remove($playlistDirectory);

        return $playlistDirectory;
    }
}