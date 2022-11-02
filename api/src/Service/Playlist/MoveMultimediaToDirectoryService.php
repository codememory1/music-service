<?php

namespace App\Service\Playlist;

use App\Entity\MultimediaPlaylist;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\PlaylistDirectory;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\JsonResponse;

class MoveMultimediaToDirectoryService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection
    ) {
    }

    public function move(MultimediaPlaylist $multimediaPlaylist, PlaylistDirectory $toDirectory): MultimediaPlaylist
    {
        $multimediaPlaylistDirectory = new MultimediaPlaylistDirectory();

        $multimediaPlaylistDirectory->setMultimediaMediaLibrary($multimediaPlaylist->getMultimediaMediaLibrary());

        $toDirectory->addMultimedia($multimediaPlaylistDirectory);

        $this->flusherService->save($multimediaPlaylist);

        return $multimediaPlaylist;
    }

    public function make(MultimediaPlaylist $multimediaPlaylist, PlaylistDirectory $toDirectory): JsonResponse
    {
        $this->make($multimediaPlaylist, $toDirectory);

        return $this->responseCollection->successUpdate('multimediaPlaylist@successMoveToDirectory');
    }
}