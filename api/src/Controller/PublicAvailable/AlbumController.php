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
use App\UseCase\Album\CreateAlbum;
use App\UseCase\Album\DeleteAlbum;
use App\UseCase\Album\PublishAlbum;
use App\UseCase\Album\UpdateAlbum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/album')]
#[Authorization]
class AlbumController extends AbstractRestController
{
    #[Route('/all', methods: Request::METHOD_GET)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_ALBUMS)]
    public function all(AlbumResponseData $responseData, AlbumRepository $albumRepository): JsonResponse
    {
        return $this->responseData($responseData, $albumRepository->findAllByUser($this->getAuthorizedUser()));
    }

    #[Route('/create', methods: Request::METHOD_POST)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CREATE_ALBUM)]
    public function create(AlbumResponseData $albumResponseData, AlbumTransformer $albumTransformer, CreateAlbum $createAlbum): JsonResponse
    {
        return $this->responseData(
            $albumResponseData,
            $createAlbum->process($albumTransformer->transformFromRequest(), $this->getAuthorizedUser()),
            PlatformCodeEnum::CREATED
        );
    }

    #[Route('/{album_id<\d+>}/edit', methods: Request::METHOD_POST)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_ALBUM)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        AlbumResponseData $responseData,
        AlbumTransformer $albumTransformer,
        UpdateAlbum $updateAlbumService
    ): JsonResponse {
        $this->throwIfAlbumNotBelongsAuthorizedUser($album);

        return $this->responseData(
            $responseData,
            $updateAlbumService->process($albumTransformer->transformFromRequest($album), $this->getAuthorizedUser()),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/{album_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_ALBUM)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        AlbumResponseData $responseData,
        DeleteAlbum $deleteAlbumService
    ): JsonResponse {
        $this->throwIfAlbumNotBelongsAuthorizedUser($album);

        return $this->responseData($responseData, $deleteAlbumService->process($album), PlatformCodeEnum::DELETED);
    }

    #[Route('/{album_id<\d+>}/publish', methods: Request::METHOD_PATCH)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_ALBUM)]
    public function publish(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        AlbumResponseData $responseData,
        PublishAlbum $publishAlbumService
    ): JsonResponse {
        $this->throwIfAlbumNotBelongsAuthorizedUser($album);

        return $this->responseData($responseData, $publishAlbumService->process($album), PlatformCodeEnum::UPDATED);
    }

    private function throwIfAlbumNotBelongsAuthorizedUser(Album $album): void
    {
        if (!$this->getAuthorizedUser()->isAlbumBelongs($album)) {
            throw EntityNotFoundException::album();
        }
    }
}