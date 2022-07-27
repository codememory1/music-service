<?php

namespace App\Service\PlaylistDirectory;

use App\DTO\PlaylistDirectoryDTO;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UpdatePlaylistDirectoryService.
 *
 * @package App\Service\PlaylistDirectory
 *
 * @author  Codememory
 */
class UpdatePlaylistDirectoryService extends AbstractService
{
    public function make(PlaylistDirectoryDTO $playlistDirectoryDTO): JsonResponse
    {
        if (false === $this->validate($playlistDirectoryDTO)) {
            return $this->validator->getResponse();
        }

        $this->flusherService->save();

        return $this->responseCollection->successUpdate('playlistDirectory@successUpdate');
    }
}