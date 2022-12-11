<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\PlaylistDirectoryTransformer;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\Playlist;
use App\Entity\PlaylistDirectory;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\Playlist\Directory\PlaylistDirectoryResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\MediaLibrary\Multimedia\AddMultimediaMediaLibraryToPlaylistDirectory;
use App\UseCase\Playlist\Directory\CreatePlaylistDirectory;
use App\UseCase\Playlist\Directory\DeletePlaylistDirectory;
use App\UseCase\Playlist\Directory\Multimedia\DeleteMultimediaFromPlaylistDirectory;
use App\UseCase\Playlist\Directory\UpdatePlaylistDirectory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/media-library/playlist')]
#[Authorization]
class PlaylistDirectoryController extends AbstractRestController
{
    #[Route('/{playlist_id<\d+>}/directory/create', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::CREATE_PLAYLIST_DIRECTORY_TO_USER)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistDirectoryTransformer $transformer,
        CreatePlaylistDirectory $createPlaylistDirectory,
        PlaylistDirectoryResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($createPlaylistDirectory->process(
            $transformer->transformFromRequest(),
            $playlist
        ));

        return $this->responseData($responseData, PlatformCodeEnum::CREATED);
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/edit', methods: 'PUT')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_PLAYLIST_DIRECTORY_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        PlaylistDirectoryTransformer $transformer,
        UpdatePlaylistDirectory $updatePlaylistDirectory,
        PlaylistDirectoryResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($updatePlaylistDirectory->process($transformer->transformFromRequest($playlistDirectory)));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_PLAYLIST_DIRECTORY_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        DeletePlaylistDirectory $deletePlaylistDirectoryService,
        PlaylistDirectoryResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($deletePlaylistDirectoryService->process($playlistDirectory));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/multimedia/{multimediaMediaLibrary_id<\d+>}/add', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::ADD_MULTIMEDIA_TO_PLAYLIST_DIRECTORY)]
    public function addMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        AddMultimediaMediaLibraryToPlaylistDirectory $addMultimediaMediaLibraryToPlaylistDirectory,
        PlaylistDirectoryResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($addMultimediaMediaLibraryToPlaylistDirectory->process(
            $multimediaMediaLibrary,
            $playlistDirectory
        ));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/directory/multimedia/{multimediaPlaylistDirectory_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_MULTIMEDIA_TO_PLAYLIST_DIRECTORY)]
    public function deleteMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaPlaylistDirectory $multimediaPlaylistDirectory,
        DeleteMultimediaFromPlaylistDirectory $deleteMultimediaFromPlaylistDirectory,
        PlaylistDirectoryResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($deleteMultimediaFromPlaylistDirectory->process($multimediaPlaylistDirectory));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }
}