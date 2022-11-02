<?php

namespace App\Service\Playlist;

use App\Entity\Playlist;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeletePlaylistService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection
    ) {}

    public function delete(Playlist $playlist): Playlist
    {
        $this->flusherService->remove($playlist);

        return $playlist;
    }

    public function request(Playlist $playlist): JsonResponse
    {
        $this->delete($playlist);

        return $this->responseCollection->successDelete('playlist@successDelete');
    }
}