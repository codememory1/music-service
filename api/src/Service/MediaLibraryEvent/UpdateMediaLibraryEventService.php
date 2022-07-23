<?php

namespace App\Service\MediaLibraryEvent;

use App\DTO\MediaLibraryEventDTO;
use App\Entity\MediaLibrary;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class UpdateMediaLibraryEventService.
 *
 * @package App\Service\MediaLibraryEvent
 *
 * @author  Codememory
 */
class UpdateMediaLibraryEventService extends AbstractService
{
    #[Required]
    public ?SaveMediaLibraryEventService $saveMediaLibraryEventService = null;

    public function make(MediaLibraryEventDTO $mediaLibraryEventDTO, MediaLibrary $mediaLibrary): JsonResponse
    {
        if (true !== $response = $this->validateFullDTO($mediaLibraryEventDTO)) {
            return $response;
        }

        $this->saveMediaLibraryEventService->make($mediaLibraryEventDTO, $mediaLibrary);

        return $this->responseCollection->successCreate('event@successUpdate');
    }
}