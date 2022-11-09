<?php

namespace App\Service\PlaylistDirectory;

use App\Entity\PlaylistDirectory;
use App\Infrastructure\Doctrine\Flusher;

final class DeletePlaylistDirectory
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function delete(PlaylistDirectory $playlistDirectory): PlaylistDirectory
    {
        $this->flusher->remove($playlistDirectory);

        return $playlistDirectory;
    }
}