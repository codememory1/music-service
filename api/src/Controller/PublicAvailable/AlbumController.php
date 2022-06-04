<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Enum\SubscriptionPermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Album\CreateAlbumService;
use App\Service\Album\DeleteAlbumService;
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

    /**
     * @param Album              $album
     * @param DeleteAlbumService $deleteAlbumService
     *
     * @return JsonResponse
     */
    #[Route('/{album_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_ALBUM)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        DeleteAlbumService $deleteAlbumService
    ): JsonResponse {
        if ($album->getUser() !== $this->authorizedUser->getUser()) {
            throw EntityNotFoundException::album();
        }

        return $deleteAlbumService->make($album);
    }
}