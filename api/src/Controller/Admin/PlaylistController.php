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
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\UseCase\Playlist\CreatePlaylist;
use App\UseCase\Playlist\DeletePlaylist;
use App\UseCase\Playlist\Multimedia\MoveMultimediaPlaylistToDirectory;
use App\UseCase\Playlist\UpdatePlaylist;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class PlaylistController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/media-library/playlist/all', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_USER_PLAYLISTS)]
    public function all(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        PlaylistResponseData $responseData,
        PlaylistRepository $playlistRepository
    ): HttpResponseCollectorInterface {
        return $this->responseData($responseData, $playlistRepository->findByUser($user));
    }

    #[Route('/media-library/playlist/{playlist_id}/read', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_USER_PLAYLISTS)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData($responseData, $playlist);
    }

    #[Route('/{user_id<\d+>}/media-library/playlist/create', methods: Request::METHOD_POST)]
    #[UserRolePermission(RolePermissionEnum::SHOW_FULL_INFO_USER_PLAYLISTS)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        PlaylistTransformer $transformer,
        CreatePlaylist $createPlaylist,
        PlaylistResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData(
            $responseData,
            $createPlaylist->process($transformer->transformFromRequest(), $user),
            PlatformCodeEnum::CREATED
        );
    }

    #[Route('/media-library/playlist/{playlist_id<\d+>}/edit', methods: Request::METHOD_POST)]
    #[UserRolePermission(RolePermissionEnum::UPDATE_PLAYLIST_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistTransformer $transformer,
        UpdatePlaylist $updatePlaylist,
        PlaylistResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData(
            $responseData,
            $updatePlaylist->process($transformer->transformFromRequest($playlist)),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/media-library/playlist/{playlist_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[UserRolePermission(RolePermissionEnum::DELETE_PLAYLIST_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        DeletePlaylist $deletePlaylist,
        PlaylistResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData($responseData, $deletePlaylist->process($playlist), PlatformCodeEnum::DELETED);
    }

    #[Route('/media-library/playlist/multimedia/{multimediaPlaylist_id<\d+>}/move/directory/{playlistDirectory_id<\d+>}', methods: Request::METHOD_PUT)]
    #[UserRolePermission(RolePermissionEnum::ADD_MULTIMEDIA_TO_PLAYLIST_DIRECTORY)]
    public function moveMultimediaToDirectory(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaPlaylist $multimediaPlaylist,
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        MoveMultimediaPlaylistToDirectory $moveMultimediaPlaylistToDirectory,
        PlaylistResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData(
            $responseData,
            $moveMultimediaPlaylistToDirectory->process($multimediaPlaylist, $playlistDirectory),
            PlatformCodeEnum::UPDATED
        );
    }
}