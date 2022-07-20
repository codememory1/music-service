<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\DTO\MultimediaMediaLibraryEventDTO;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UpdateMultimediaMediaLibraryEventService.
 *
 * @package App\Service\MultimediaMediaLibraryEvent
 *
 * @author  Codememory
 */
class UpdateMultimediaMediaLibraryEventService extends AbstractService
{
    public function make(MultimediaMediaLibraryEventDTO $multimediaMediaLibraryEventDTO): JsonResponse
    {
        if (true !== $response = $this->validateFullDTO($multimediaMediaLibraryEventDTO)) {
            return $response;
        }

        $this->em->flush();

        return $this->responseCollection->successCreate('event@successUpdate');
    }
}