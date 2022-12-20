<?php

namespace App\UseCase\MediaLibrary\Multimedia\Event;

use App\Entity\MultimediaMediaLibraryEvent;
use App\Infrastructure\Doctrine\Flusher;

final class CancelMultimediaMediaLibraryEvent
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