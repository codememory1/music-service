<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\Dto\Transfer\MultimediaMediaLibraryEventDto;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaMediaLibraryEvent;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

class AddMultimediaMediaLibraryEventService extends AbstractService
{
    #[Required]
    public ?SaveMultimediaMediaLibraryEventService $saveMultimediaMediaLibraryEventService = null;

    public function add(MultimediaMediaLibraryEventDto $multimediaMediaLibraryEventDto, MultimediaMediaLibrary $multimediaMediaLibrary): MultimediaMediaLibraryEvent
    {
        $this->validate($multimediaMediaLibraryEventDto);

        $multimediaMediaLibraryEvent = $multimediaMediaLibraryEventDto->getEntity();

        $multimediaMediaLibraryEvent->setMultimediaMediaLibrary($multimediaMediaLibrary);

        $this->validate($multimediaMediaLibrary);

        $this->saveMultimediaMediaLibraryEventService->make($multimediaMediaLibraryEventDto, $multimediaMediaLibrary);

        return $multimediaMediaLibraryEvent;
    }

    public function request(MultimediaMediaLibraryEventDto $multimediaMediaLibraryEventDto, MultimediaMediaLibrary $multimediaMediaLibrary): JsonResponse
    {
        $this->add($multimediaMediaLibraryEventDto, $multimediaMediaLibrary);

        return $this->responseCollection->successCreate('event@successAdd');
    }
}