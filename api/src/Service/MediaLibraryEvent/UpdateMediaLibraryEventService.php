<?php

namespace App\Service\MediaLibraryEvent;

use App\DTO\MediaLibraryEventDTO;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UpdateMediaLibraryEventService.
 *
 * @package App\Service\MediaLibraryEvent
 *
 * @author  Codememory
 */
class UpdateMediaLibraryEventService extends AbstractService
{
    public function make(MediaLibraryEventDTO $mediaLibraryEventDTO): JsonResponse
    {
        if (true !== $response = $this->validateFullDTO($mediaLibraryEventDTO)) {
            return $response;
        }

        $this->em->flush();

        return $this->responseCollection->successCreate('event@successUpdate');
    }
}