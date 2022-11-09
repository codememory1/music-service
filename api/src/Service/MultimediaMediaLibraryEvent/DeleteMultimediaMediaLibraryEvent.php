<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\Entity\MultimediaMediaLibraryEvent;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteMultimediaMediaLibraryEvent
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function delete(MultimediaMediaLibraryEvent $multimediaMediaLibraryEvent): MultimediaMediaLibraryEvent
    {
        $this->flusher->save($multimediaMediaLibraryEvent);

        return $multimediaMediaLibraryEvent;
    }
}