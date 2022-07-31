<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\Dto\Transfer\MultimediaMediaLibraryEventDto;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaMediaLibraryEvent;
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

    public function update(MultimediaMediaLibraryEventDto $multimediaMediaLibraryEventDto, MultimediaMediaLibrary $multimediaMediaLibrary): MultimediaMediaLibraryEvent
    {
        $this->validateWithEntity($multimediaMediaLibraryEventDto);

        $this->saveMultimediaMediaLibraryEventService->make($multimediaMediaLibraryEventDto, $multimediaMediaLibrary);

        return $multimediaMediaLibraryEventDto->getEntity();
    }

    public function request(MultimediaMediaLibraryEventDto $multimediaMediaLibraryEventDto, MultimediaMediaLibrary $multimediaMediaLibrary): JsonResponse
    {
        $this->update($multimediaMediaLibraryEventDto, $multimediaMediaLibrary);

        return $this->responseCollection->successCreate('event@successUpdate');
    }
}