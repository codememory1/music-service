<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\AlbumTransformer;
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
#[Authorization]
class AlbumController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_ALBUMS)]
    public function all(AlbumResponseData $albumResponseData, AlbumRepository $albumRepository): JsonResponse
    {
        $albumResponseData->setEntities($albumRepository->findAllByUser($this->getAuthorizedUser()));
        $albumResponseData->collect();

        return $this->responseCollection->dataOutput($albumResponseData->getResponse());
    }

    #[Route('/create', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CREATE_ALBUM)]
    public function create(AlbumTransformer $albumTransformer, CreateAlbumService $createAlbumService): JsonResponse
    {
        return $createAlbumService->request($albumTransformer->transformFromRequest(), $this->getAuthorizedUser());
    }

    #[Route('/{album_id<\d+>}/edit', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_ALBUM)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        AlbumTransformer $albumTransformer,
        UpdateAlbumService $updateAlbumService
    ): JsonResponse {
        $this->throwIfAlbumNotBelongsAuthorizedUser($album);

        return $updateAlbumService->request($albumTransformer->transformFromRequest($album), $this->getAuthorizedUser());
    }

    #[Route('/{album_id<\d+>}/delete', methods: 'DELETE')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_ALBUM)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        DeleteAlbumService $deleteAlbumService
    ): JsonResponse {
        $this->throwIfAlbumNotBelongsAuthorizedUser($album);

        return $deleteAlbumService->request($album);
    }

    #[Route('/{album_id<\d+>}/publish', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_ALBUM)]
    public function publish(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        PublishAlbumService $publishAlbumService
    ): JsonResponse {
        $this->throwIfAlbumNotBelongsAuthorizedUser($album);

        return $publishAlbumService->request($album);
    }

    private function throwIfAlbumNotBelongsAuthorizedUser(Album $album): void
    {
        if (false === $this->getAuthorizedUser()->isAlbumBelongs($album)) {
            throw EntityNotFoundException::album();
        }
    }
}