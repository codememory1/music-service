<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\PlaylistDTO;
use App\Entity\MultimediaPlaylist;
use App\Entity\Playlist;
use App\Entity\PlaylistDirectory;
use App\Entity\User;
use App\Enum\RolePermissionEnum;
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
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/user')]
class PlaylistController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/media-library/playlist/all', methods: 'GET')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::SHOW_USER_PLAYLISTS)]
    public function all(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        PlaylistResponseData $playlistResponseData,
        PlaylistRepository $playlistRepository
    ): JsonResponse {
        $playlistResponseData->setEntities($playlistRepository->findByUser($user));
        $playlistResponseData->collect();

        return $this->responseCollection->dataOutput($playlistResponseData->getResponse());
    }

    #[Route('/media-library/playlist/{playlist_id}/read', methods: 'GET')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::SHOW_USER_PLAYLISTS)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistResponseData $playlistResponseData
    ): JsonResponse {
        $playlistResponseData->setEntities($playlist);
        $playlistResponseData->collect();

        return $this->responseCollection->dataOutput($playlistResponseData->getResponse(true));
    }

    #[Route('/{user_id<\d+>}/media-library/playlist/create', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::SHOW_FULL_INFO_USER_PLAYLISTS)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        PlaylistDTO $playlistDTO,
        CreatePlaylistService $createPlaylistService
    ): JsonResponse {
        return $createPlaylistService->make($playlistDTO->collect(), $user);
    }

    #[Route('/media-library/playlist/{playlist_id<\d+>}/edit', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::UPDATE_PLAYLIST_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistDTO $playlistDTO,
        UpdatePlaylistService $updatePlaylistService
    ): JsonResponse {
        $playlistDTO->setEntity($playlist);

        return $updatePlaylistService->make($playlistDTO->collect());
    }

    #[Route('/media-library/playlist/{playlist_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::DELETE_PLAYLIST_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        DeletePlaylistService $deletePlaylistService
    ): JsonResponse {
        return $deletePlaylistService->make($playlist);
    }

    #[Route('/playlist/multimedia/{multimediaPlaylist_id<\d+>}/move/directory/{playlistDirectory_id<\d+>}', methods: 'PUT')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::ADD_MULTIMEDIA_TO_PLAYLIST_DIRECTORY)]
    public function moveMultimediaToDirectory(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaPlaylist $multimediaPlaylist,
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        MoveMultimediaToDirectoryService $moveMultimediaToDirectoryService
    ): JsonResponse {
        return $moveMultimediaToDirectoryService->make($multimediaPlaylist, $playlistDirectory);
    }
}