<?php

namespace App\Service\PlaylistDirectory;

use App\Entity\PlaylistDirectory;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeletePlaylistDirectoryService.
 *
 * @package App\Service\PlaylistDirectory
 *
 * @author  Codememory
 */
class DeletePlaylistDirectoryService extends AbstractService
{
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