<?php

namespace App\Service\MediaLibraryEvent;

use App\Dto\Transfer\MediaLibraryEventDto;
use App\Entity\MediaLibrary;
use App\Entity\MediaLibraryEvent;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

class AddMediaLibraryEventService extends AbstractService
{
    #[Required]
    public ?SaveMediaLibraryEventService $saveMediaLibraryEventService = null;

    public function add(MediaLibraryEventDto $mediaLibraryEventDto, MediaLibrary $mediaLibrary): MediaLibraryEvent
    {
        $this->validate($mediaLibraryEventDto);

        $mediaLibraryEvent = $mediaLibraryEventDto->getEntity();

        $mediaLibraryEvent->setMediaLibrary($mediaLibrary);

        $this->validate($mediaLibraryEvent);

        $this->saveMediaLibraryEventService->make($mediaLibraryEventDto, $mediaLibrary, $mediaLibraryEvent);

        return $mediaLibraryEvent;
    }

    public function request(MediaLibraryEventDto $mediaLibraryEventDto, MediaLibrary $mediaLibrary): JsonResponse
    {
        $this->add($mediaLibraryEventDto, $mediaLibrary);

        return $this->responseCollection->successCreate('event@successAdd');
    }
}