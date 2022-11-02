<?php

namespace App\Service\MediaLibraryEvent;

use App\Dto\Transfer\MediaLibraryEventDto;
use App\Entity\MediaLibrary;
use App\Entity\MediaLibraryEvent;
use App\Service\FlusherService;

class SaveMediaLibraryEventService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly EventPayloadHandlerService $eventPayloadHandlerService
    ) {
    }

    public function make(MediaLibraryEventDto $mediaLibraryEventDto, MediaLibrary $mediaLibrary, ?MediaLibraryEvent $mediaLibraryEvent = null): void
    {
        $this->eventPayloadHandlerService->handler($mediaLibraryEventDto, $mediaLibrary);

        $this->flusherService->save($mediaLibraryEvent);
    }
}