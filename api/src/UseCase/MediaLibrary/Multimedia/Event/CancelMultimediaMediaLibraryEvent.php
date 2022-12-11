<?php

namespace App\UseCase\MultimediaMediaLibrary\Event;

use App\Entity\MultimediaMediaLibraryEvent;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteMultimediaMediaLibraryEvent
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function process(MultimediaMediaLibraryEvent $multimediaMediaLibraryEvent): MultimediaMediaLibraryEvent
    {
        $this->flusher->save($multimediaMediaLibraryEvent);

        return $multimediaMediaLibraryEvent;
    }
}