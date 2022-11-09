<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\AlbumTransformer;
use App\Entity\Album;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\AlbumRepository;
use App\ResponseData\General\Album\AlbumResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\Album\CreateAlbum;
use App\Service\Album\DeleteAlbum;
use App\Service\Album\PublishAlbum;
use App\Service\Album\UpdateAlbum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/album')]
#[Authorization]
class AlbumController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_ALBUMS)]
    public function all(AlbumResponseData $responseData, AlbumRepository $albumRepository): JsonResponse
    {
        $responseData->setEntities($albumRepository->findAllByUser($this->getAuthorizedUser()));

        return $this->responseData($responseData);
    }

    #[Route('/create', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CREATE_ALBUM)]
    public function create(AlbumResponseData $albumResponseData, AlbumTransformer $albumTransformer, CreateAlbum $createAlbum): JsonResponse
    {
        $albumResponseData->setEntities($createAlbum->create(
            $albumTransformer->transformFromRequest(),
            $this->getAuthorizedUser()
        ));

        return $this->responseData($albumResponseData, PlatformCodeEnum::CREATED);
    }

    #[Route('/{album_id<\d+>}/edit', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_ALBUM)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        AlbumResponseData $responseData,
        AlbumTransformer $albumTransformer,
        UpdateAlbum $updateAlbumService
    ): JsonResponse {
        $this->throwIfAlbumNotBelongsAuthorizedUser($album);

        $responseData->setEntities($updateAlbumService->update(
            $albumTransformer->transformFromRequest($album),
            $this->getAuthorizedUser()
        ));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/{album_id<\d+>}/delete', methods: 'DELETE')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_ALBUM)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        AlbumResponseData $responseData,
        DeleteAlbum $deleteAlbumService
    ): JsonResponse {
        $this->throwIfAlbumNotBelongsAuthorizedUser($album);

        $responseData->setEntities($deleteAlbumService->delete($album));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }

    #[Route('/{album_id<\d+>}/publish', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_ALBUM)]
    public function publish(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        AlbumResponseData $responseData,
        PublishAlbum $publishAlbumService
    ): JsonResponse {
        $this->throwIfAlbumNotBelongsAuthorizedUser($album);

        $responseData->setEntities($publishAlbumService->publish($album));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    private function throwIfAlbumNotBelongsAuthorizedUser(Album $album): void
    {
        if (false === $this->getAuthorizedUser()->isAlbumBelongs($album)) {
            throw EntityNotFoundException::album();
        }
    }
}