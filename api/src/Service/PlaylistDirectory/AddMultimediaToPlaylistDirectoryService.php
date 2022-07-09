<?php

namespace App\Service\PlaylistDirectory;

use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\PlaylistDirectory;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AddMultimediaToPlaylistDirectoryService.
 *
 * @package App\Service\PlaylistDirectory
 *
 * @author  Codememory
 */
class AddMultimediaToPlaylistDirectoryService extends AbstractService
{
    public function make(PlaylistDirectory $playlistDirectory, MultimediaMediaLibrary $multimediaMediaLibrary): JsonResponse
    {
        $multimediaPlaylistDirectory = new MultimediaPlaylistDirectory();

        $multimediaPlaylistDirectory->setMultimediaMediaLibrary($multimediaMediaLibrary);

        $playlistDirectory->addMultimedia($multimediaPlaylistDirectory);

        $this->em->flush();

        return $this->responseCollection->successUpdate('playlistDirectory@successAddMultimedia');
    }
}