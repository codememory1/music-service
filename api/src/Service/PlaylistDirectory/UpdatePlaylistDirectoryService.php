<?php

namespace App\Service\PlaylistDirectory;

use App\Dto\Transfer\PlaylistDirectoryDto;
use App\Entity\PlaylistDirectory;
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
    public function update(PlaylistDirectoryDto $playlistDirectoryDto): PlaylistDirectory
    {
        $this->validate($playlistDirectoryDto);

        $this->flusherService->save();

        return $playlistDirectoryDto->getEntity();
    }

    public function request(PlaylistDirectoryDto $playlistDirectoryDto): JsonResponse
    {
        $this->update($playlistDirectoryDto);

        return $this->responseCollection->successUpdate('playlistDirectory@successUpdate');
    }
}