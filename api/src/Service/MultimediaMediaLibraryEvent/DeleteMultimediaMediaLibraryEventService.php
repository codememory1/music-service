<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\Entity\MultimediaMediaLibraryEvent;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteMultimediaMediaLibraryEventService extends AbstractService
{
    public function delete(MultimediaMediaLibraryEvent $multimediaMediaLibraryEvent): MultimediaMediaLibraryEvent
    {
        $this->flusherService->save($multimediaMediaLibraryEvent);

        return $multimediaMediaLibraryEvent;
    }

    public function request(MultimediaMediaLibraryEvent $multimediaMediaLibraryEvent): JsonResponse
    {
        $this->delete($multimediaMediaLibraryEvent);

        return $this->responseCollection->successCreate('event@successDelete');
    }
}