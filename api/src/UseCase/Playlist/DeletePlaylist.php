<?php

namespace App\UseCase\Playlist;

use App\Entity\Playlist;
use App\Infrastructure\Doctrine\Flusher;

final class DeletePlaylist
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function process(Playlist $playlist): Playlist
    {
        $this->flusher->remove($playlist);

        return $playlist;
    }
}