<?php

namespace App\Service\MediaLibrary;

use App\Entity\MultimediaMediaLibrary;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteMultimediaMediaLibraryService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection
    ) {}

    public function delete(MultimediaMediaLibrary $multimediaMediaLibrary): MultimediaMediaLibrary
    {
        $this->flusherService->remove($multimediaMediaLibrary);

        return $multimediaMediaLibrary;
    }

    public function request(MultimediaMediaLibrary $multimediaMediaLibrary): JsonResponse
    {
        $this->delete($multimediaMediaLibrary);

        return $this->responseCollection->successDelete('multimediaMediaLibrary@successDelete');
    }
}