<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\SubscriptionPermission;
use App\DTO\PlaylistDTO;
use App\Enum\SubscriptionPermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Service\Playlist\CreatePlaylistService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PlaylistController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/user/media-library')]
class PlaylistController extends AbstractRestController
{
    #[Route('/playlist/create', methods: 'POST')]
    #[Authorization]
//    #[SubscriptionPermission(SubscriptionPermissionEnum::CREATE_PLAYLIST)]
    public function create(PlaylistDTO $playlistDTO, CreatePlaylistService $createPlaylistService): JsonResponse
    {
        return $createPlaylistService->make($playlistDTO->collect(), $this->authorizedUser->getUser());
    }
}