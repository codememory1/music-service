<?php

namespace App\UseCase\MediaLibrary\Event;

use App\Entity\MediaLibraryEvent;
use App\Infrastructure\Doctrine\Flusher;

final class CancelMediaLibraryEvent
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function process(MediaLibraryEvent $mediaLibraryEvent): MediaLibraryEvent
    {
        $this->flusher->remove($mediaLibraryEvent);

        return $mediaLibraryEvent;
    }
}