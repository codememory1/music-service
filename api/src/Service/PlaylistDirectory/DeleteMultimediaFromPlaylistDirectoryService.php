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
    public function make(MultimediaPlaylistDirectory $multimediaPlaylistDirectory): JsonResponse
    {
        $this->em->remove($multimediaPlaylistDirectory);
        $this->em->flush();

        return $this->responseCollection->successDelete('multimedia@successDelete');
    }
}