<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\Dto\Transfer\MultimediaMediaLibraryEventDto;
use App\Entity\MultimediaMediaLibrary;
use App\Service\FlusherService;
use Symfony\Contracts\Service\Attribute\Required;

class SaveMultimediaMediaLibraryEventService
{
    public function __construct(
        private readonly FlusherService $flusherService
    ) {}

    #[Required]
    public ?EventPayloadHandlerService $eventPayloadHandlerService = null;

    public function make(MultimediaMediaLibraryEventDto $multimediaMediaLibraryEventDto, MultimediaMediaLibrary $multimediaMediaLibrary): void
    {
        $this->eventPayloadHandlerService->handler($multimediaMediaLibraryEventDto, $multimediaMediaLibrary);

        $this->flusherService->save($multimediaMediaLibrary);
    }
}