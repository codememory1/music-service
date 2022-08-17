<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\PlaylistTransformer;
use App\Entity\MultimediaPlaylist;
use App\Entity\Playlist;
use App\Entity\PlaylistDirectory;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\PlaylistRepository;
use App\ResponseData\PlaylistResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\Playlist\CreatePlaylistService;
use App\Service\Playlist\DeletePlaylistService;
use App\Service\Playlist\MoveMultimediaToDirectoryService;
use App\Service\Playlist\UpdatePlaylistService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/media-library')]
#[Authorization]
class PlaylistController extends AbstractRestController
{
    #[Route('/playlist/all', methods: 'GET')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_PLAYLISTS)]
    public function all(PlaylistResponseData $playlistResponseData, PlaylistRepository $playlistRepository): JsonResponse
    {
        $playlistResponseData->setEntities($playlistRepository->findByUser($this->getAuthorizedUser()));

        return $this->responseCollection->dataOutput($playlistResponseData->getResponse());
    }

    #[Route('/playlist/{playlist_id}/read', methods: 'GET')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_PLAYLISTS)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistResponseData $playlistResponseData
    ): JsonResponse {
        $this->throwIfPlaylistNotBelongsAuthorizedUser($playlist);

        $playlistResponseData->setEntities($playlist);

        return $this->responseCollection->dataOutput($playlistResponseData->getResponse(true));
    }

    #[Route('/playlist/create', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CREATE_PLAYLIST)]
    public function create(PlaylistTransformer $playlistTransformer, CreatePlaylistService $createPlaylistService): JsonResponse
    {
        return $createPlaylistService->request($playlistTransformer->transformFromRequest(), $this->getAuthorizedUser());
    }

    #[Route('/playlist/{playlist_id<\d+>}/edit', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_PLAYLIST)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistTransformer $playlistTransformer,
        UpdatePlaylistService $updatePlaylistService
    ): JsonResponse {
        $this->throwIfPlaylistNotBelongsAuthorizedUser($playlist);

        return $updatePlaylistService->request($playlistTransformer->transformFromRequest($playlist));
    }

    #[Route('/playlist/{playlist_id<\d+>}/delete', methods: 'DELETE')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_PLAYLIST)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        DeletePlaylistService $deletePlaylistService
    ): JsonResponse {
        $this->throwIfPlaylistNotBelongsAuthorizedUser($playlist);

        return $deletePlaylistService->request($playlist);
    }

    #[Route('/playlist/multimedia/{multimediaPlaylist_id<\d+>}/move/directory/{playlistDirectory_id<\d+>}', methods: 'PUT')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST)]
    public function moveMultimediaToDirectory(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaPlaylist $multimediaPlaylist,
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        MoveMultimediaToDirectoryService $moveMultimediaToDirectoryService
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isMultimediaPlaylistBelongs($multimediaPlaylist)) {
            throw EntityNotFoundException::multimedia();
        }

        if (false === $this->getAuthorizedUser()->isPlaylistDirectoryBelongs($playlistDirectory)) {
            throw EntityNotFoundException::playlistDirectory();
        }

        return $moveMultimediaToDirectoryService->make($multimediaPlaylist, $playlistDirectory);
    }

    private function throwIfPlaylistNotBelongsAuthorizedUser(Playlist $playlist): void
    {
        if (false === $this->getAuthorizedUser()->isPlaylistBelongs($playlist)) {
            throw EntityNotFoundException::multimedia();
        }
    }
}