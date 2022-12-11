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
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\PlaylistRepository;
use App\ResponseData\General\Playlist\PlaylistResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\Playlist\CreatePlaylist;
use App\UseCase\Playlist\DeletePlaylist;
use App\UseCase\Playlist\Multimedia\MoveMultimediaPlaylistToDirectory;
use App\UseCase\Playlist\UpdatePlaylist;
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
        PlaylistResponseData $responseData,
        PlaylistRepository $playlistRepository
    ): JsonResponse {
        $responseData->setEntities($playlistRepository->findByUser($user));

        return $this->responseData($responseData);
    }

    #[Route('/media-library/playlist/{playlist_id}/read', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::SHOW_USER_PLAYLISTS)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($playlist);

        return $this->responseData($responseData);
    }

    #[Route('/{user_id<\d+>}/media-library/playlist/create', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::SHOW_FULL_INFO_USER_PLAYLISTS)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        PlaylistTransformer $transformer,
        CreatePlaylist $createPlaylist,
        PlaylistResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($createPlaylist->process($transformer->transformFromRequest(), $user));

        return $this->responseData($responseData, PlatformCodeEnum::CREATED);
    }

    #[Route('/media-library/playlist/{playlist_id<\d+>}/edit', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_PLAYLIST_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistTransformer $transformer,
        UpdatePlaylist $updatePlaylist,
        PlaylistResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($updatePlaylist->process($transformer->transformFromRequest($playlist)));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/media-library/playlist/{playlist_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_PLAYLIST_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        DeletePlaylist $deletePlaylist,
        PlaylistResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($deletePlaylist->process($playlist));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }

    #[Route('/media-library/playlist/multimedia/{multimediaPlaylist_id<\d+>}/move/directory/{playlistDirectory_id<\d+>}', methods: 'PUT')]
    #[UserRolePermission(RolePermissionEnum::ADD_MULTIMEDIA_TO_PLAYLIST_DIRECTORY)]
    public function moveMultimediaToDirectory(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaPlaylist $multimediaPlaylist,
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        MoveMultimediaPlaylistToDirectory $moveMultimediaPlaylistToDirectory,
        PlaylistResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($moveMultimediaPlaylistToDirectory->process($multimediaPlaylist, $playlistDirectory));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }
}