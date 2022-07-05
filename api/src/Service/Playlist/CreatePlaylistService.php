<?php

namespace App\Service\Playlist;

use App\DTO\PlaylistDTO;
use App\Entity\User;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CreatePlaylistService.
 *
 * @package App\Service\Playlist
 *
 * @author  Codememory
 */
class CreatePlaylistService extends AbstractService
{
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

        $this->em->persist($playlistEntity);
        $this->em->flush();

        return $this->responseCollection->successCreate('playlist@successCreate');
    }
}