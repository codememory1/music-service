<?php

namespace App\Service\Playlist;

use App\Dto\Transfer\PlaylistDto;
use App\Entity\Playlist;
use App\Entity\User;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

class CreatePlaylistService extends AbstractService
{
    #[Required]
    public ?SavePlaylistService $savePlaylistService = null;

    public function create(PlaylistDto $playlistDto, User $forUser): Playlist
    {
        $this->validate($playlistDto);

        if (null === $forUser->getMediaLibrary()) {
            throw EntityNotFoundException::mediaLibraryNotCreated();
        }

        $playlist = $playlistDto->getEntity();

        $forUser->getMediaLibrary()->addPlaylist($playlist);

        $this->savePlaylistService->make($playlistDto, $playlist);

        return $playlist;
    }

    public function request(PlaylistDto $playlistDto, User $forUser): JsonResponse
    {
        $this->create($playlistDto, $forUser);

        return $this->responseCollection->successCreate('playlist@successCreate');
    }
}