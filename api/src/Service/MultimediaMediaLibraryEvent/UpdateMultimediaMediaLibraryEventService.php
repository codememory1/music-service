<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\DTO\MultimediaMediaLibraryEventDTO;
use App\Entity\MultimediaMediaLibrary;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class UpdateMultimediaMediaLibraryEventService.
 *
 * @package App\Service\MultimediaMediaLibraryEvent
 *
 * @author  Codememory
 */
class UpdateMultimediaMediaLibraryEventService extends AbstractService
{
    #[Required]
    public ?SaveMultimediaMediaLibraryEventService $saveMultimediaMediaLibraryEventService = null;

    public function make(MultimediaMediaLibraryEventDTO $multimediaMediaLibraryEventDTO, MultimediaMediaLibrary $multimediaMediaLibrary): JsonResponse
    {
        if (true !== $response = $this->validateFullDTO($multimediaMediaLibraryEventDTO)) {
            return $response;
        }

        $this->saveMultimediaMediaLibraryEventService->make($multimediaMediaLibraryEventDTO, $multimediaMediaLibrary);

        return $this->responseCollection->successCreate('event@successUpdate');
    }
}