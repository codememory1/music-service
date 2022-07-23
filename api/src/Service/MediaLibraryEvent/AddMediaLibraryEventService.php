<?php

namespace App\Service\MediaLibraryEvent;

use App\DTO\MediaLibraryEventDTO;
use App\Entity\MediaLibrary;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AddMediaLibraryEventService.
 *
 * @package App\Service\MediaLibraryEvent
 *
 * @author  codememory
 */
class AddMediaLibraryEventService extends AbstractService
{
    public function make(MediaLibraryEventDTO $mediaLibraryEventDTO, MediaLibrary $mediaLibrary): JsonResponse
    {
        $mediaLibraryEventEntity = $mediaLibraryEventDTO->getEntity();

        $mediaLibrary->addEvent($mediaLibraryEventEntity);

        if (true !== $response = $this->validateFullDTO($mediaLibraryEventDTO)) {
            return $response;
        }

        $this->em->persist($mediaLibraryEventEntity);
        $this->em->flush();

        return $this->responseCollection->successCreate('event@successAdd');
    }
}