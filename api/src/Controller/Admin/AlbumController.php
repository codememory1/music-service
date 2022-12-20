<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\AlbumTransformer;
use App\Entity\Album;
use App\Entity\User;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
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

#[Route('/user')]
#[Authorization]
class AlbumController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/album/all', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_FULL_INFO_ALBUMS)]
    public function all(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        AlbumResponseData $responseData,
        AlbumRepository $albumRepository
    ): JsonResponse {
        return $this->responseData($responseData, $albumRepository->findAllByUser($user));
    }

    #[Route('/{user_id<\d+>}/album/create', methods: Request::METHOD_POST)]
    #[UserRolePermission(RolePermissionEnum::CREATE_ALBUM_TO_USER)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        AlbumTransformer $transformer,
        CreateAlbum $createAlbum,
        AlbumResponseData $responseData
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $createAlbum->process($transformer->transformFromRequest(), $user),
            PlatformCodeEnum::CREATED
        );
    }

    #[Route('/album/{album_id<\d+>}/edit', methods: Request::METHOD_POST)]
    #[UserRolePermission(RolePermissionEnum::UPDATE_ALBUM_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        AlbumTransformer $transformer,
        UpdateAlbum $updateAlbum,
        AlbumResponseData $responseData
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $updateAlbum->process($transformer->transformFromRequest($album), $album->getUser()),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/album/{album_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[UserRolePermission(RolePermissionEnum::DELETE_ALBUM_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        DeleteAlbum $deleteAlbum,
        AlbumResponseData $responseData
    ): JsonResponse {
        return $this->responseData($responseData, $deleteAlbum->process($album), PlatformCodeEnum::DELETED);
    }

    #[Route('/album/{album_id<\d+>}/publish', methods: Request::METHOD_PATCH)]
    #[UserRolePermission(RolePermissionEnum::ALBUM_STATUS_CONTROL_TO_USER)]
    public function publish(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        PublishAlbum $publishAlbum,
        AlbumResponseData $responseData
    ): JsonResponse {
        return $this->responseData($responseData, $publishAlbum->process($album), PlatformCodeEnum::UPDATED);
    }
}