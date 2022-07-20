<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\DTO\MultimediaMediaLibraryEventDTO;
use App\Entity\MultimediaMediaLibrary;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AddMultimediaMediaLibraryEventService.
 *
 * @package App\Service\MultimediaMediaLibraryEvent
 *
 * @author  Codememory
 */
class AddMultimediaMediaLibraryEventService extends AbstractService
{
    public function make(MultimediaMediaLibraryEventDTO $multimediaMediaLibraryEventDTO, MultimediaMediaLibrary $multimediaMediaLibrary): JsonResponse
    {
        $multimediaMediaLibraryEventEntity = $multimediaMediaLibraryEventDTO->getEntity();

        $multimediaMediaLibraryEventEntity->setMultimediaMediaLibrary($multimediaMediaLibrary);

        if (true !== $response = $this->validateFullDTO($multimediaMediaLibraryEventDTO)) {
            return $response;
        }

        $this->em->persist($multimediaMediaLibraryEventEntity);
        $this->em->flush();

        return $this->responseCollection->successCreate('event@successAdd');
    }
}