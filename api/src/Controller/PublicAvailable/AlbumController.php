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
use App\Service\Album\PublishAlbumService;
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
    #[Route('/all', methods: 'GET')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_ALBUMS)]
    public function all(AlbumResponseData $albumResponseData, AlbumRepository $albumRepository): JsonResponse
    {
        $albumResponseData->setEntities($albumRepository->findAllByUser($this->getAuthorizedUser()));
        $albumResponseData->collect();

        return $this->responseCollection->dataOutput($albumResponseData->getResponse());
    }

    #[Route('/create', methods: 'POST')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CREATE_ALBUM)]
    public function create(AlbumDTO $albumDTO, CreateAlbumService $createAlbumService): JsonResponse
    {
        return $createAlbumService->make($albumDTO->collect(), $this->getAuthorizedUser());
    }

    #[Route('/{album_id<\d+>}/edit', methods: 'POST')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_ALBUM)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        AlbumDTO $albumDTO,
        UpdateAlbumService $updateAlbumService
    ): JsonResponse {
        $this->throwIfAlbumNotBelongsAuthorizedUser($album);

        $albumDTO->setEntity($album);
        $albumDTO->collect();

        return $updateAlbumService->make($albumDTO, $this->getAuthorizedUser());
    }

    #[Route('/{album_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_ALBUM)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        DeleteAlbumService $deleteAlbumService
    ): JsonResponse {
        $this->throwIfAlbumNotBelongsAuthorizedUser($album);

        return $deleteAlbumService->make($album);
    }

    #[Route('/{album_id<\d+>}/publish', methods: 'PATCH')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_ALBUM)]
    public function publish(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        PublishAlbumService $publishAlbumService
    ): JsonResponse {
        $this->throwIfAlbumNotBelongsAuthorizedUser($album);

        return $publishAlbumService->make($album);
    }

    private function throwIfAlbumNotBelongsAuthorizedUser(Album $album): void
    {
        if (false === $this->getAuthorizedUser()->isAlbumBelongs($album)) {
            throw EntityNotFoundException::album();
        }
    }
}