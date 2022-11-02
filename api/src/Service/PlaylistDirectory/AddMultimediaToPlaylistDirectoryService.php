<?php

namespace App\Service\PlaylistDirectory;

use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\PlaylistDirectory;
use App\Exception\Http\EntityExistException;
use App\Repository\MultimediaPlaylistRepository;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use App\Service\Playlist\CheckExistMultimediaToPlaylistDirectoriesService;
use Symfony\Component\HttpFoundation\JsonResponse;

class AddMultimediaToPlaylistDirectoryService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection,
        private readonly MultimediaPlaylistRepository $multimediaPlaylistRepository
    ){}

    public function add(PlaylistDirectory $playlistDirectory, MultimediaMediaLibrary $multimediaMediaLibrary): MultimediaPlaylistDirectory
    {
        $finedMultimediaPlaylist = $this->multimediaPlaylistRepository->findOneBy([
            'playlist' => $playlistDirectory->getPlaylist(),
            'multimediaMediaLibrary' => $multimediaMediaLibrary
        ]);
        $checkExistMultimediaToPlaylistDirectories = new CheckExistMultimediaToPlaylistDirectoriesService();

        $checkExistMultimediaToPlaylistDirectories->throwIfExist(
            $playlistDirectory->getPlaylist()->getDirectories(),
            $multimediaMediaLibrary
        );

        if (null !== $finedMultimediaPlaylist) {
            throw EntityExistException::multimediaPlaylist();
        }

        $multimediaPlaylistDirectory = new MultimediaPlaylistDirectory();

        $multimediaPlaylistDirectory->setMultimediaMediaLibrary($multimediaMediaLibrary);
        $multimediaPlaylistDirectory->setPlaylistDirectory($playlistDirectory);

        $this->flusherService->save($multimediaPlaylistDirectory);

        return $multimediaPlaylistDirectory;
    }

    public function request(PlaylistDirectory $playlistDirectory, MultimediaMediaLibrary $multimediaMediaLibrary): JsonResponse
    {
        $this->add($playlistDirectory, $multimediaMediaLibrary);

        return $this->responseCollection->successUpdate('playlistDirectory@successAddMultimedia');
    }
}