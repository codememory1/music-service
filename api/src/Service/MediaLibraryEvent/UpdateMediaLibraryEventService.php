<?php

namespace App\Service\MediaLibraryEvent;

use App\Dto\Transfer\MediaLibraryEventDto;
use App\Entity\MediaLibrary;
use App\Entity\MediaLibraryEvent;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

class UpdateMediaLibraryEventService extends AbstractService
{
    #[Required]
    public ?SaveMediaLibraryEventService $saveMediaLibraryEventService = null;

    public function update(MediaLibraryEventDto $mediaLibraryEventDto, MediaLibrary $mediaLibrary): MediaLibraryEvent
    {
        $this->validateWithEntity($mediaLibraryEventDto);

        $this->saveMediaLibraryEventService->make($mediaLibraryEventDto, $mediaLibrary);

        return $mediaLibraryEventDto->getEntity();
    }

    public function request(MediaLibraryEventDto $mediaLibraryEventDto, MediaLibrary $mediaLibrary): JsonResponse
    {
        $this->update($mediaLibraryEventDto, $mediaLibrary);

        return $this->responseCollection->successCreate('event@successUpdate');
    }
}