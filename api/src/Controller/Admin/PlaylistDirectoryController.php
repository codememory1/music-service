<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\PlaylistDirectoryDTO;
use App\Entity\Playlist;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\PlaylistDirectory\CreatePlaylistDirectoryService;
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
}