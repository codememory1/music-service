<?php

namespace App\Service\MediaLibraryEvent;

use App\Dto\Transfer\MediaLibraryEventDto;
use App\Entity\MediaLibrary;
use App\Entity\MediaLibraryEvent;
use App\Infrastructure\Doctrine\Flusher;

final class UpsertMediaLibrary
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly EventPayloadHandler $eventPayloadHandler
    ) {
    }

    public function save(MediaLibraryEventDto $dto, MediaLibrary $mediaLibrary, ?MediaLibraryEvent $mediaLibraryEvent = null): void
    {
        $this->eventPayloadHandler->handler($dto, $mediaLibrary);

        $this->flusher->save($mediaLibraryEvent);
    }
}