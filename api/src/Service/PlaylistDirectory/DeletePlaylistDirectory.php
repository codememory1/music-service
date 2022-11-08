<?php

namespace App\Service\PlaylistDirectory;

use App\Entity\PlaylistDirectory;
use App\Service\FlusherService;

final class DeletePlaylistDirectory
{
    public function __construct(
        private readonly FlusherService $flusher
    ) {
    }

    public function delete(PlaylistDirectory $playlistDirectory): PlaylistDirectory
    {
        $this->flusher->remove($playlistDirectory);

        return $playlistDirectory;
    }
}