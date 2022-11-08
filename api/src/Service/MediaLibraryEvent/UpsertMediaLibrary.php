<?php

namespace App\Service\MediaLibraryEvent;

use App\Dto\Transfer\MediaLibraryEventDto;
use App\Entity\MediaLibrary;
use App\Entity\MediaLibraryEvent;
use App\Service\FlusherService;

class UpsertMediaLibrary
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly EventPayloadHandler $eventPayloadHandler
    ) {
    }

    public function save(MediaLibraryEventDto $dto, MediaLibrary $mediaLibrary, ?MediaLibraryEvent $mediaLibraryEvent = null): void
    {
        $this->eventPayloadHandler->handler($dto, $mediaLibrary);

        $this->flusherService->save($mediaLibraryEvent);
    }
}