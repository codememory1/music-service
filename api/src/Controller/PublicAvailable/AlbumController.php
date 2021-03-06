<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Enum\SubscriptionPermissionEnum;
use App\Repository\AlbumRepository;
use App\ResponseData\AlbumResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Album\CreateAlbumService;
use App\Service\Album\DeleteAlbumService;
use App\Service\Album\UpdateAlbumService;
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
     * @param AlbumResponseData $albumResponseData
     * @param AlbumRepository   $albumRepository
     *
     * @return JsonResponse
     */
    #[Route('/all', methods: 'GET')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_ALBUMS)]
    public function all(AlbumResponseData $albumResponseData, AlbumRepository $albumRepository): JsonResponse
    {
        $albumResponseData->setEntities($albumRepository->findByCriteria([
            'user' => $this->authorizedUser->getUser()
        ]));
        $albumResponseData->collect();

        return $this->responseCollection->dataOutput($albumResponseData->getResponse());
    }

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
     * @param AlbumDTO           $albumDTO
     * @param UpdateAlbumService $updateAlbumService
     *
     * @return JsonResponse
     */
    #[Route('/{album_id<\d+>}/edit', methods: 'POST')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_ALBUM)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        AlbumDTO $albumDTO,
        UpdateAlbumService $updateAlbumService
    ): JsonResponse {
        if ($album->getUser() !== $this->authorizedUser->getUser()) {
            throw EntityNotFoundException::album();
        }

        $albumDTO->setEntity($album);

        return $updateAlbumService->make($albumDTO->collect(), $this->authorizedUser->getUser());
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