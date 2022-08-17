<?php

namespace App\Service\PlaylistDirectory;

use App\Dto\Transfer\PlaylistDirectoryDto;
use App\Entity\Playlist;
use App\Entity\PlaylistDirectory;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreatePlaylistDirectoryService extends AbstractService
{
    public function create(PlaylistDirectoryDto $playlistDirectoryDto, Playlist $toPlaylist): PlaylistDirectory
    {
        $this->validate($playlistDirectoryDto);

        $playlistDirectory = $playlistDirectoryDto->getEntity();

        $playlistDirectory->setPlaylist($toPlaylist);

        $this->flusherService->save($playlistDirectory);

        return $playlistDirectory;
    }

    public function request(PlaylistDirectoryDto $playlistDirectoryDto, Playlist $toPlaylist): JsonResponse
    {
        $this->create($playlistDirectoryDto, $toPlaylist);

        return $this->responseCollection->successCreate('playlistDirectory@successCreate');
    }
}