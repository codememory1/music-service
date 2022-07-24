<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\DTO\PlaylistDirectoryDTO;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\Playlist;
use App\Entity\PlaylistDirectory;
use App\Enum\SubscriptionPermissionEnum;
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
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/user/media-library/playlist')]
#[Authorization]
class PlaylistDirectoryController extends AbstractRestController
{
    #[Route('/{playlist_id<\d+>}/directory/create', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CREATE_DIRECTORY_TO_PLAYLIST)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistDirectoryDTO $playlistDirectoryDTO,
        CreatePlaylistDirectoryService $createPlaylistDirectoryService
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isPlaylistBelongs($playlist)) {
            throw EntityNotFoundException::playlist();
        }

        return $createPlaylistDirectoryService->make($playlistDirectoryDTO->collect(), $playlist);
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/edit', methods: 'PUT')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        PlaylistDirectoryDTO $playlistDirectoryDTO,
        UpdatePlaylistDirectoryService $updatePlaylistDirectoryService
    ): JsonResponse {
        $this->throwIfPlaylistDirectoryNotBelongsAuthorizedUser($playlistDirectory);

        $playlistDirectoryDTO->setEntity($playlistDirectory);
        $playlistDirectoryDTO->collect();

        return $updatePlaylistDirectoryService->make($playlistDirectoryDTO);
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/delete', methods: 'DELETE')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_DIRECTORY_TO_PLAYLIST)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        DeletePlaylistDirectoryService $deletePlaylistDirectoryService
    ): JsonResponse {
        $this->throwIfPlaylistDirectoryNotBelongsAuthorizedUser($playlistDirectory);

        return $deletePlaylistDirectoryService->make($playlistDirectory);
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/multimedia/{multimediaMediaLibrary_id<\d+>}/add', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST)]
    public function addMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        AddMultimediaToPlaylistDirectoryService $addMultimediaToPlaylistDirectoryService
    ): JsonResponse {
        $this->throwIfPlaylistDirectoryNotBelongsAuthorizedUser($playlistDirectory);

        if (false === $this->getAuthorizedUser()->isMultimediaMediaLibraryBelongs($multimediaMediaLibrary)) {
            throw EntityNotFoundException::multimedia();
        }

        return $addMultimediaToPlaylistDirectoryService->make($playlistDirectory, $multimediaMediaLibrary);
    }

    #[Route('/directory/multimedia/{multimediaPlaylistDirectory_id<\d+>}/delete', methods: 'DELETE')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST)]
    public function deleteMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaPlaylistDirectory $multimediaPlaylistDirectory,
        DeleteMultimediaFromPlaylistDirectoryService $deleteMultimediaFromPlaylistDirectoryService
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isMultimediaPlaylistDirectoryBelongs($multimediaPlaylistDirectory)) {
            throw EntityNotFoundException::multimedia();
        }

        return $deleteMultimediaFromPlaylistDirectoryService->make($multimediaPlaylistDirectory);
    }

    private function throwIfPlaylistDirectoryNotBelongsAuthorizedUser(PlaylistDirectory $playlistDirectory): void
    {
        if (false === $this->getAuthorizedUser()->isPlaylistDirectoryBelongs($playlistDirectory)) {
            throw EntityNotFoundException::playlistDirectory();
        }
    }
}