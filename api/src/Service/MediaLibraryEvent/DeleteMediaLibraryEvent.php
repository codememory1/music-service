<?php

namespace App\Service\MediaLibraryEvent;

use App\Entity\MediaLibraryEvent;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteMediaLibraryEvent
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function delete(MediaLibraryEvent $mediaLibraryEvent): MediaLibraryEvent
    {
        $this->flusher->remove($mediaLibraryEvent);

        return $mediaLibraryEvent;
    }
}