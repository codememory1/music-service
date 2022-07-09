<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\DTO\PlaylistDirectoryDTO;
use App\Entity\Playlist;
use App\Entity\PlaylistDirectory;
use App\Enum\SubscriptionPermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\PlaylistDirectory\CreatePlaylistDirectoryService;
use App\Service\PlaylistDirectory\DeletePlaylistDirectoryService;
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
class PlaylistDirectoryController extends AbstractRestController
{
    #[Route('/{playlist_id<\d+>}/directory/create', methods: 'POST')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CREATE_DIRECTORY_TO_PLAYLIST)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistDirectoryDTO $playlistDirectoryDTO,
        CreatePlaylistDirectoryService $createPlaylistDirectoryService
    ): JsonResponse {
        if ($playlist->getMediaLibrary() !== $this->authorizedUser->getUser()->getMediaLibrary()) {
            throw EntityNotFoundException::playlist();
        }

        return $createPlaylistDirectoryService->make($playlistDirectoryDTO->collect(), $playlist);
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CREATE_DIRECTORY_TO_PLAYLIST)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        DeletePlaylistDirectoryService $deletePlaylistDirectoryService
    ): JsonResponse {
        if ($playlistDirectory->getPlaylist()->getMediaLibrary() !== $this->authorizedUser->getUser()->getMediaLibrary()) {
            throw EntityNotFoundException::playlistDirectory();
        }

        return $deletePlaylistDirectoryService->make($playlistDirectory);
    }
}