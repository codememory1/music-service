<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\PlaylistDirectoryDTO;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\Playlist;
use App\Entity\PlaylistDirectory;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\PlaylistDirectory\AddMultimediaToPlaylistDirectoryService;
use App\Service\PlaylistDirectory\CreatePlaylistDirectoryService;
use App\Service\PlaylistDirectory\DeleteMultimediaFromPlaylistDirectoryService;
use App\Service\PlaylistDirectory\DeletePlaylistDirectoryService;
use App\Service\PlaylistDirectory\UpdatePlaylistDirectoryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PlaylistDirectoryController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/user/media-library/playlist')]
class PlaylistDirectoryController extends AbstractRestController
{
    #[Route('/{playlist_id<\d+>}/directory/create', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::CREATE_PLAYLIST_DIRECTORY_TO_USER)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistDirectoryDTO $playlistDirectoryDTO,
        CreatePlaylistDirectoryService $createPlaylistDirectoryService
    ): JsonResponse {
        return $createPlaylistDirectoryService->make($playlistDirectoryDTO->collect(), $playlist);
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/edit', methods: 'PUT')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::UPDATE_PLAYLIST_DIRECTORY_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        PlaylistDirectoryDTO $playlistDirectoryDTO,
        UpdatePlaylistDirectoryService $updatePlaylistDirectoryService
    ): JsonResponse {
        $playlistDirectoryDTO->setEntity($playlistDirectory);

        return $updatePlaylistDirectoryService->make($playlistDirectoryDTO);
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::DELETE_PLAYLIST_DIRECTORY_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        DeletePlaylistDirectoryService $deletePlaylistDirectoryService
    ): JsonResponse {
        return $deletePlaylistDirectoryService->make($playlistDirectory);
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/multimedia/{multimediaMediaLibrary_id<\d+>}/add', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::ADD_MULTIMEDIA_TO_PLAYLIST_DIRECTORY)]
    public function addMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        AddMultimediaToPlaylistDirectoryService $addMultimediaToPlaylistDirectoryService
    ): JsonResponse {
        return $addMultimediaToPlaylistDirectoryService->make($playlistDirectory, $multimediaMediaLibrary);
    }

    #[Route('/directory/multimedia/{multimediaPlaylistDirectory_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::DELETE_MULTIMEDIA_TO_PLAYLIST_DIRECTORY)]
    public function deleteMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaPlaylistDirectory $multimediaPlaylistDirectory,
        DeleteMultimediaFromPlaylistDirectoryService $deleteMultimediaFromPlaylistDirectoryService
    ): JsonResponse {
        return $deleteMultimediaFromPlaylistDirectoryService->make($multimediaPlaylistDirectory);
    }
}