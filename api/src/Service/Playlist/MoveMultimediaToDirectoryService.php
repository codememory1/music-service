<?php

namespace App\Service\Playlist;

use App\Entity\MultimediaPlaylist;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\PlaylistDirectory;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class MoveMultimediaToDirectoryService.
 *
 * @package App\Service\Playlist
 *
 * @author  Codememory
 */
class MoveMultimediaToDirectoryService extends AbstractService
{
    public function make(MultimediaPlaylist $multimediaPlaylist, PlaylistDirectory $toDirectory): JsonResponse
    {
        $multimediaPlaylistDirectory = new MultimediaPlaylistDirectory();

        $multimediaPlaylistDirectory->setMultimediaMediaLibrary($multimediaPlaylist->getMultimediaMediaLibrary());

        $toDirectory->addMultimedia($multimediaPlaylistDirectory);

        $this->em->remove($multimediaPlaylist);
        $this->em->flush();

        return $this->responseCollection->successUpdate('multimediaPlaylist@successMoveToDirectory');
    }
}