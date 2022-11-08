<?php

namespace App\Service\PlaylistDirectory;

use App\Entity\MultimediaPlaylistDirectory;
use App\Service\FlusherService;

final class DeleteMultimediaFromPlaylistDirectory
{
    public function __construct(
        private readonly FlusherService $flusher
    ) {
    }

    public function delete(MultimediaPlaylistDirectory $multimediaPlaylistDirectory): MultimediaPlaylistDirectory
    {
        $this->flusher->remove($multimediaPlaylistDirectory);

        return $multimediaPlaylistDirectory;
    }
}