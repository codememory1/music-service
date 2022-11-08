<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\PlaylistDirectoryTransformer;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\Playlist;
use App\Entity\PlaylistDirectory;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Rest\Controller\AbstractRestController;
use App\Service\PlaylistDirectory\AddMultimediaToPlaylistDirectory;
use App\Service\PlaylistDirectory\CreatePlaylistDirectory;
use App\Service\PlaylistDirectory\DeleteMultimediaFromPlaylistDirectory;
use App\Service\PlaylistDirectory\DeletePlaylistDirectory;
use App\Service\PlaylistDirectory\UpdatePlaylistDirectory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/media-library/playlist')]
#[Authorization]
class PlaylistDirectoryController extends AbstractRestController
{
    #[Route('/{playlist_id<\d+>}/directory/create', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CREATE_DIRECTORY_TO_PLAYLIST)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistDirectoryTransformer $playlistDirectoryTransformer,
        CreatePlaylistDirectory $createPlaylistDirectoryService
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isPlaylistBelongs($playlist)) {
            throw EntityNotFoundException::playlist();
        }

        return $createPlaylistDirectoryService->request($playlistDirectoryTransformer->transformFromRequest(), $playlist);
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/edit', methods: 'PUT')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        PlaylistDirectoryTransformer $playlistDirectoryTransformer,
        UpdatePlaylistDirectory $updatePlaylistDirectoryService
    ): JsonResponse {
        $this->throwIfPlaylistDirectoryNotBelongsAuthorizedUser($playlistDirectory);

        return $updatePlaylistDirectoryService->request($playlistDirectoryTransformer->transformFromRequest($playlistDirectory));
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/delete', methods: 'DELETE')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_DIRECTORY_TO_PLAYLIST)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        DeletePlaylistDirectory $deletePlaylistDirectoryService
    ): JsonResponse {
        $this->throwIfPlaylistDirectoryNotBelongsAuthorizedUser($playlistDirectory);

        return $deletePlaylistDirectoryService->request($playlistDirectory);
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/multimedia/{multimediaMediaLibrary_id<\d+>}/add', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST)]
    public function addMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        AddMultimediaToPlaylistDirectory $addMultimediaToPlaylistDirectoryService
    ): JsonResponse {
        $this->throwIfPlaylistDirectoryNotBelongsAuthorizedUser($playlistDirectory);

        if (false === $this->getAuthorizedUser()->isMultimediaMediaLibraryBelongs($multimediaMediaLibrary)) {
            throw EntityNotFoundException::multimedia();
        }

        return $addMultimediaToPlaylistDirectoryService->request($playlistDirectory, $multimediaMediaLibrary);
    }

    #[Route('/directory/multimedia/{multimediaPlaylistDirectory_id<\d+>}/delete', methods: 'DELETE')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST)]
    public function deleteMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaPlaylistDirectory $multimediaPlaylistDirectory,
        DeleteMultimediaFromPlaylistDirectory $deleteMultimediaFromPlaylistDirectoryService
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isMultimediaPlaylistDirectoryBelongs($multimediaPlaylistDirectory)) {
            throw EntityNotFoundException::multimedia();
        }

        return $deleteMultimediaFromPlaylistDirectoryService->request($multimediaPlaylistDirectory);
    }

    private function throwIfPlaylistDirectoryNotBelongsAuthorizedUser(PlaylistDirectory $playlistDirectory): void
    {
        if (false === $this->getAuthorizedUser()->isPlaylistDirectoryBelongs($playlistDirectory)) {
            throw EntityNotFoundException::playlistDirectory();
        }
    }
}