<?php

namespace App\Service\MediaLibraryEvent;

use App\DTO\MediaLibraryEventDTO;
use App\Entity\MediaLibrary;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class AddMediaLibraryEventService.
 *
 * @package App\Service\MediaLibraryEvent
 *
 * @author  codememory
 */
class AddMediaLibraryEventService extends AbstractService
{
    #[Required]
    public ?SaveMediaLibraryEventService $saveMediaLibraryEventService = null;

    public function make(MediaLibraryEventDTO $mediaLibraryEventDTO, MediaLibrary $mediaLibrary): JsonResponse
    {
        $mediaLibraryEventEntity = $mediaLibraryEventDTO->getEntity();

        $mediaLibrary->addEvent($mediaLibraryEventEntity);

        if (true !== $response = $this->validateFullDTO($mediaLibraryEventDTO)) {
            return $response;
        }

        $this->saveMediaLibraryEventService->make($mediaLibraryEventDTO, $mediaLibrary, $mediaLibraryEventEntity);

        return $this->responseCollection->successCreate('event@successAdd');
    }
}