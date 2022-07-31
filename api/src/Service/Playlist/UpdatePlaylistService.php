<?php

namespace App\Service\Playlist;

use App\Dto\Transfer\PlaylistDto;
use App\Entity\Playlist;
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

    public function update(PlaylistDto $playlistDto): Playlist
    {
        $this->validate($playlistDto);

        $playlist = $playlistDto->getEntity();

        $this->savePlaylistService->make($playlistDto, $playlist);

        return $playlist;
    }

    public function request(PlaylistDto $playlistDto): JsonResponse
    {
        $this->update($playlistDto);

        return $this->responseCollection->successUpdate('playlist@successUpdate');
    }
}