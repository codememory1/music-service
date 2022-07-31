<?php

namespace App\Service\PlaylistDirectory;

use App\Entity\MultimediaPlaylistDirectory;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeleteMultimediaFromPlaylistDirectoryService.
 *
 * @package App\Service\PlaylistDirectory
 *
 * @author  Codememory
 */
class DeleteMultimediaFromPlaylistDirectoryService extends AbstractService
{
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