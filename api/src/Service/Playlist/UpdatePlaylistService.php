<?php

namespace App\Service\Playlist;

use App\DTO\PlaylistDTO;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class UpdatePlaylistService.
 *
 * @package App\Service\Playlist
 *
 * @author  Codememory
 */
class UpdatePlaylistService extends AbstractService
{
    #[Required]
    public ?SavePlaylistService $savePlaylistService = null;

    public function make(PlaylistDTO $playlistDTO): JsonResponse
    {
        if (false === $this->validate($playlistDTO)) {
            return $this->validator->getResponse();
        }

        $this->savePlaylistService->make($playlistDTO, $playlistDTO->getEntity());

        return $this->responseCollection->successUpdate('playlist@successUpdate');
    }
}