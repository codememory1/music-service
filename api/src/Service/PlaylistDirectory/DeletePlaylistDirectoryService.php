<?php

namespace App\Service\PlaylistDirectory;

use App\Entity\PlaylistDirectory;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeletePlaylistDirectoryService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection
    ) {}

    public function delete(PlaylistDirectory $playlistDirectory): PlaylistDirectory
    {
        $this->flusherService->remove($playlistDirectory);

        return $playlistDirectory;
    }

    public function request(PlaylistDirectory $playlistDirectory): JsonResponse
    {
        $this->delete($playlistDirectory);

        return $this->responseCollection->successDelete('playlistDirectory@successDelete');
    }
}