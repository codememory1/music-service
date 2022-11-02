<?php

namespace App\Service\MediaLibraryEvent;

use App\Entity\MediaLibraryEvent;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteMediaLibraryEventService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection
    ) {}

    public function delete(MediaLibraryEvent $mediaLibraryEvent): MediaLibraryEvent
    {
        $this->flusherService->remove($mediaLibraryEvent);

        return $mediaLibraryEvent;
    }

    public function request(MediaLibraryEvent $mediaLibraryEvent): JsonResponse
    {
        $this->delete($mediaLibraryEvent);

        return $this->responseCollection->successCreate('event@successDelete');
    }
}