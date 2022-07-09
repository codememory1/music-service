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
    public function make(PlaylistDirectory $playlistDirectory): JsonResponse
    {
        $this->em->remove($playlistDirectory);
        $this->em->flush();

        return $this->responseCollection->successDelete('playlistDirectory@successDelete');
    }
}