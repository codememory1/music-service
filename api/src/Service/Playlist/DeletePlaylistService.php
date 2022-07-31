<?php

namespace App\Service\Playlist;

use App\Entity\Playlist;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeletePlaylistService.
 *
 * @package App\Service\Playlist
 *
 * @author  Codememory
 */
class DeletePlaylistService extends AbstractService
{
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