<?php

namespace App\Service\PlaylistDirectory;

use App\DTO\PlaylistDirectoryDTO;
use App\Entity\Playlist;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CreatePlaylistDirectoryService.
 *
 * @package App\Service\PlaylistDirectory
 *
 * @author  Codememory
 */
class CreatePlaylistDirectoryService extends AbstractService
{
    public function make(PlaylistDirectoryDTO $playlistDirectoryDTO, Playlist $toPlaylist): JsonResponse
    {
        if (false === $this->validate($playlistDirectoryDTO)) {
            return $this->validator->getResponse();
        }

        $playlistDirectory = $playlistDirectoryDTO->getEntity();

        $playlistDirectory->setPlaylist($toPlaylist);

        $this->flusherService->save($playlistDirectory);

        return $this->responseCollection->successCreate('playlistDirectory@successCreate');
    }
}