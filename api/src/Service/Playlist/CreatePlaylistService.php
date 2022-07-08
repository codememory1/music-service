<?php

namespace App\Service\Playlist;

use App\DTO\PlaylistDTO;
use App\Entity\User;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class CreatePlaylistService.
 *
 * @package App\Service\Playlist
 *
 * @author  Codememory
 */
class CreatePlaylistService extends AbstractService
{
    #[Required]
    public ?SavePlaylistService $savePlaylistService = null;

    public function make(PlaylistDTO $playlistDTO, User $forUser): JsonResponse
    {
        if (false === $this->validate($playlistDTO)) {
            return $this->validator->getResponse();
        }

        if (null === $forUser->getMediaLibrary()) {
            throw EntityNotFoundException::mediaLibraryNotCreated();
        }

        $playlistEntity = $playlistDTO->getEntity();

        $playlistEntity->setMediaLibrary($forUser->getMediaLibrary());

        $this->savePlaylistService->make($playlistDTO, $playlistEntity, $forUser);

        return $this->responseCollection->successCreate('playlist@successCreate');
    }
}