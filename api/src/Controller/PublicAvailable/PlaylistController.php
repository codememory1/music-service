<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\DTO\PlaylistDTO;
use App\Entity\Playlist;
use App\Enum\SubscriptionPermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Playlist\CreatePlaylistService;
use App\Service\Playlist\DeletePlaylistService;
use App\Service\Playlist\UpdatePlaylistService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PlaylistController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/user/media-library')]
class PlaylistController extends AbstractRestController
{
    #[Route('/playlist/create', methods: 'POST')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CREATE_PLAYLIST)]
    public function create(PlaylistDTO $playlistDTO, CreatePlaylistService $createPlaylistService): JsonResponse
    {
        return $createPlaylistService->make($playlistDTO->collect(), $this->authorizedUser->getUser());
    }

    #[Route('/playlist/{playlist_id<\d+>}/edit', methods: 'POST')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_PLAYLIST)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistDTO $playlistDTO,
        UpdatePlaylistService $updatePlaylistService
    ): JsonResponse {
        if ($playlist->getMediaLibrary() !== $this->authorizedUser->getUser()->getMediaLibrary()) {
            throw EntityNotFoundException::playlist();
        }

        $playlistDTO->setEntity($playlist);

        return $updatePlaylistService->make($playlistDTO->collect());
    }

    #[Route('/playlist/{playlist_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_PLAYLIST)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        DeletePlaylistService $deletePlaylistService
    ): JsonResponse {
        if ($playlist->getMediaLibrary() !== $this->authorizedUser->getUser()->getMediaLibrary()) {
            throw EntityNotFoundException::playlist();
        }

        return $deletePlaylistService->make($playlist);
    }
}