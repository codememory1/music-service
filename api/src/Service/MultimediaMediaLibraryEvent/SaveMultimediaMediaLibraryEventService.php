<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\DTO\MultimediaMediaLibraryEventDTO;
use App\Entity\MultimediaMediaLibrary;
use App\Service\AbstractService;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class SaveMultimediaMediaLibraryEventService.
 *
 * @package App\Service\MultimediaMediaLibraryEvent
 *
 * @author  Codememory
 */
class SaveMultimediaMediaLibraryEventService extends AbstractService
{
    #[Required]
    public ?EventPayloadHandlerService $eventPayloadHandlerService = null;

    public function make(MultimediaMediaLibraryEventDTO $multimediaMediaLibraryEventDTO, MultimediaMediaLibrary $multimediaMediaLibrary): void
    {
        $this->eventPayloadHandlerService->handler($multimediaMediaLibraryEventDTO, $multimediaMediaLibrary);

        $this->flusherService->save($multimediaMediaLibrary);
    }
}