<?php

namespace App\Service\MediaLibraryEvent;

use App\Entity\MediaLibraryEvent;
use App\Service\FlusherService;

class DeleteMediaLibraryEvent
{
    public function __construct(
        private readonly FlusherService $flusherService
    ) {
    }

    public function delete(MediaLibraryEvent $mediaLibraryEvent): MediaLibraryEvent
    {
        $this->flusherService->remove($mediaLibraryEvent);

        return $mediaLibraryEvent;
    }
}