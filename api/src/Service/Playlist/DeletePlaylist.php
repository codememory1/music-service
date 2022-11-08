<?php

namespace App\Service\Playlist;

use App\Entity\Playlist;
use App\Service\FlusherService;

class DeletePlaylist
{
    public function __construct(
        private readonly FlusherService $flusher
    ) {
    }

    public function delete(Playlist $playlist): Playlist
    {
        $this->flusher->remove($playlist);

        return $playlist;
    }
}