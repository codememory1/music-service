<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\Dto\Transfer\MultimediaMediaLibraryEventDto;
use App\Entity\MultimediaMediaLibrary;
use App\Service\FlusherService;

class UpsertMultimediaMediaLibraryEvent
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly EventPayloadHandler $eventPayloadHandler
    ) {
    }

    public function save(MultimediaMediaLibraryEventDto $dto, MultimediaMediaLibrary $multimediaMediaLibrary): void
    {
        $this->eventPayloadHandler->handler($dto, $multimediaMediaLibrary);

        $this->flusher->save($multimediaMediaLibrary);
    }
}