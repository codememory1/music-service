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
    public function make(Playlist $playlist): JsonResponse
    {
        $this->em->remove($playlist);
        $this->em->flush();

        return $this->responseCollection->successDelete('playlist@successDelete');
    }
}