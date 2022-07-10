<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\DTO\PlaylistDTO;
use App\Entity\MultimediaPlaylist;
use App\Entity\Playlist;
use App\Entity\PlaylistDirectory;
use App\Enum\SubscriptionPermissionEnum;
use App\Repository\PlaylistRepository;
use App\ResponseData\PlaylistResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Playlist\CreatePlaylistService;
use App\Service\Playlist\DeletePlaylistService;
use App\Service\Playlist\MoveMultimediaToDirectoryService;
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
    #[Route('/playlist/all', methods: 'GET')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_PLAYLISTS)]
    public function all(PlaylistResponseData $playlistResponseData, PlaylistRepository $playlistRepository): JsonResponse
    {
        $playlistResponseData->setEntities($playlistRepository->findByUser(
            $this->authorizedUser->getUser()
        ));
        $playlistResponseData->collect();

        return $this->responseCollection->dataOutput($playlistResponseData->getResponse());
    }

    #[Route('/playlist/{playlist_id}/read', methods: 'GET')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_PLAYLISTS)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistResponseData $playlistResponseData
    ): JsonResponse {
        if ($playlist->getMediaLibrary() !== $this->authorizedUser->getUser()->getMediaLibrary()) {
            throw EntityNotFoundException::playlist();
        }

        $playlistResponseData->setEntities($playlist);
        $playlistResponseData->collect();

        return $this->responseCollection->dataOutput($playlistResponseData->getResponse(true));
    }

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

    #[Route('/playlist/multimedia/{multimediaPlaylist_id<\d+>}/move/directory/{playlistDirectory_id<\d+>}', methods: 'PUT')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST)]
    public function moveMultimediaToDirectory(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaPlaylist $multimediaPlaylist,
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        MoveMultimediaToDirectoryService $moveMultimediaToDirectoryService
    ): JsonResponse {
        $authorizedUserMediaLibrary = $this->authorizedUser->getUser()->getMediaLibrary();

        if ($multimediaPlaylist->getMultimediaMediaLibrary()->getMediaLibrary() !== $authorizedUserMediaLibrary) {
            throw EntityNotFoundException::multimedia();
        }

        if ($playlistDirectory->getPlaylist()->getMediaLibrary() !== $authorizedUserMediaLibrary) {
            throw EntityNotFoundException::playlistDirectory();
        }

        return $moveMultimediaToDirectoryService->make($multimediaPlaylist, $playlistDirectory);
    }
}