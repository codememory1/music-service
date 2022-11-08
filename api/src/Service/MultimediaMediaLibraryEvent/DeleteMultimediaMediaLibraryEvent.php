<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\Entity\MultimediaMediaLibraryEvent;
use App\Service\FlusherService;

class DeleteMultimediaMediaLibraryEvent
{
    public function __construct(
        private readonly FlusherService $flusher
    ) {
    }

    public function delete(MultimediaMediaLibraryEvent $multimediaMediaLibraryEvent): MultimediaMediaLibraryEvent
    {
        $this->flusher->save($multimediaMediaLibraryEvent);

        return $multimediaMediaLibraryEvent;
    }
}