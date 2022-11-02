<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\Entity\MultimediaMediaLibraryEvent;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteMultimediaMediaLibraryEventService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection
    ) {}

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