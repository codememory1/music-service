<?php

namespace App\Service\MediaLibraryEvent;

use App\Dto\Transfer\MediaLibraryEventDto;
use App\Entity\MediaLibrary;
use App\Entity\MediaLibraryEvent;
use App\Service\AbstractService;
use Symfony\Contracts\Service\Attribute\Required;

class SaveMediaLibraryEventService extends AbstractService
{
    #[Required]
    public ?EventPayloadHandlerService $eventPayloadHandlerService = null;

    public function make(MediaLibraryEventDto $mediaLibraryEventDto, MediaLibrary $mediaLibrary, ?MediaLibraryEvent $mediaLibraryEvent = null): void
    {
        $this->eventPayloadHandlerService->handler($mediaLibraryEventDto, $mediaLibrary);

        $this->flusherService->save($mediaLibraryEvent);
    }
}