<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\PlaylistTransformer;
use App\Entity\MultimediaPlaylist;
use App\Entity\Playlist;
use App\Entity\PlaylistDirectory;
use App\Entity\User;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\PlaylistRepository;
use App\ResponseData\PlaylistResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\Playlist\CreatePlaylist;
use App\Service\Playlist\DeletePlaylist;
use App\Service\Playlist\MoveMultimediaToDirectory;
use App\Service\Playlist\UpdatePlaylist;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class PlaylistController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/media-library/playlist/all', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::SHOW_USER_PLAYLISTS)]
    public function all(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        PlaylistResponseData $playlistResponseData,
        PlaylistRepository $playlistRepository
    ): JsonResponse {
        $playlistResponseData->setEntities($playlistRepository->findByUser($user));

        return $this->responseData($playlistResponseData);
    }

    #[Route('/media-library/playlist/{playlist_id}/read', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::SHOW_USER_PLAYLISTS)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistResponseData $playlistResponseData
    ): JsonResponse {
        $playlistResponseData->setEntities($playlist);

        return $this->responseData($playlistResponseData);
    }

    #[Route('/{user_id<\d+>}/media-library/playlist/create', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::SHOW_FULL_INFO_USER_PLAYLISTS)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        PlaylistTransformer $playlistTransformer,
        CreatePlaylist $createPlaylistService
    ): JsonResponse {
        return $createPlaylistService->request($playlistTransformer->transformFromRequest(), $user);
    }

    #[Route('/media-library/playlist/{playlist_id<\d+>}/edit', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_PLAYLIST_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistTransformer $playlistTransformer,
        UpdatePlaylist $updatePlaylistService
    ): JsonResponse {
        return $updatePlaylistService->request($playlistTransformer->transformFromRequest($playlist));
    }

    #[Route('/media-library/playlist/{playlist_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_PLAYLIST_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        DeletePlaylist $deletePlaylistService
    ): JsonResponse {
        return $deletePlaylistService->request($playlist);
    }

    #[Route('/media-library/playlist/multimedia/{multimediaPlaylist_id<\d+>}/move/directory/{playlistDirectory_id<\d+>}', methods: 'PUT')]
    #[UserRolePermission(RolePermissionEnum::ADD_MULTIMEDIA_TO_PLAYLIST_DIRECTORY)]
    public function moveMultimediaToDirectory(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaPlaylist $multimediaPlaylist,
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        MoveMultimediaToDirectory $moveMultimediaToDirectoryService
    ): JsonResponse {
        return $moveMultimediaToDirectoryService->make($multimediaPlaylist, $playlistDirectory);
    }
}