<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\SubscriptionPermission;
use App\DTO\AlbumDTO;
use App\Enum\SubscriptionPermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Service\Album\CreateAlbumService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AlbumController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/album')]
class AlbumController extends AbstractRestController
{
    /**
     * @param AlbumDTO           $albumDTO
     * @param CreateAlbumService $createAlbumService
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CREATE_ALBUM)]
    public function create(AlbumDTO $albumDTO, CreateAlbumService $createAlbumService): JsonResponse
    {
        return $createAlbumService->make($albumDTO->collect(), $this->authorizedUser->getUser());
    }
}