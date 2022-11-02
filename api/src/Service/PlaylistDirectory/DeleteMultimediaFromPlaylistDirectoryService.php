<?php

namespace App\Service\PlaylistDirectory;

use App\Entity\MultimediaPlaylistDirectory;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteMultimediaFromPlaylistDirectoryService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection
    ) {
    }

    public function delete(MultimediaPlaylistDirectory $multimediaPlaylistDirectory): MultimediaPlaylistDirectory
    {
        $this->flusherService->remove($multimediaPlaylistDirectory);

        return $multimediaPlaylistDirectory;
    }

    public function request(MultimediaPlaylistDirectory $multimediaPlaylistDirectory): JsonResponse
    {
        $this->delete($multimediaPlaylistDirectory);

        return $this->responseCollection->successDelete('multimedia@successDelete');
    }
}