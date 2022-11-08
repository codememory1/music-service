<?php

namespace App\Service\MediaLibrary;

use App\Entity\MultimediaMediaLibrary;
use App\Service\FlusherService;

class DeleteMultimediaMediaLibrary
{
    public function __construct(
        private readonly FlusherService $flusher
    ) {
    }

    public function delete(MultimediaMediaLibrary $multimediaMediaLibrary): MultimediaMediaLibrary
    {
        $this->flusher->remove($multimediaMediaLibrary);

        return $multimediaMediaLibrary;
    }
}