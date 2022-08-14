<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\Dto\Transfer\MultimediaMediaLibraryEventDto;
use App\Entity\MultimediaMediaLibrary;
use App\Service\AbstractService;
use Symfony\Contracts\Service\Attribute\Required;

class SaveMultimediaMediaLibraryEventService extends AbstractService
{
    #[Required]
    public ?EventPayloadHandlerService $eventPayloadHandlerService = null;

    public function make(MultimediaMediaLibraryEventDto $multimediaMediaLibraryEventDto, MultimediaMediaLibrary $multimediaMediaLibrary): void
    {
        $this->eventPayloadHandlerService->handler($multimediaMediaLibraryEventDto, $multimediaMediaLibrary);

        $this->flusherService->save($multimediaMediaLibrary);
    }
}