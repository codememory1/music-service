<?php

namespace App\UseCase\Playlist\Directory\Multimedia;

use App\Entity\MultimediaPlaylistDirectory;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteMultimediaFromPlaylistDirectory
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function process(MultimediaPlaylistDirectory $multimediaPlaylistDirectory): MultimediaPlaylistDirectory
    {
        $this->flusher->remove($multimediaPlaylistDirectory);

        return $multimediaPlaylistDirectory;
    }
}