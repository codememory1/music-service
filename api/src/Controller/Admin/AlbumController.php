<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\AlbumTransformer;
use App\Entity\Album;
use App\Entity\User;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\AlbumRepository;
use App\ResponseData\AlbumResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\Album\CreateAlbumService;
use App\Service\Album\DeleteAlbumService;
use App\Service\Album\PublishAlbumService;
use App\Service\Album\UpdateAlbumService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class AlbumController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/album/all', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::SHOW_FULL_INFO_ALBUMS)]
    public function all(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        AlbumResponseData $albumResponseData,
        AlbumRepository $albumRepository
    ): JsonResponse {
        $albumResponseData->setEntities($albumRepository->findAllByUser($user));

        return $this->responseCollection->dataOutput($albumResponseData->getResponse());
    }

    #[Route('/{user_id<\d+>}/album/create', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::CREATE_ALBUM_TO_USER)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        AlbumTransformer $albumTransformer,
        CreateAlbumService $createAlbumService
    ): JsonResponse {
        return $createAlbumService->request($albumTransformer->transformFromRequest(), $user);
    }

    #[Route('/album/{album_id<\d+>}/edit', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_ALBUM_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        AlbumTransformer $albumTransformer,
        UpdateAlbumService $updateAlbumService
    ): JsonResponse {
        return $updateAlbumService->request($albumTransformer->transformFromRequest($album), $album->getUser());
    }

    #[Route('/album/{album_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_ALBUM_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        DeleteAlbumService $deleteAlbumService
    ): JsonResponse {
        return $deleteAlbumService->request($album);
    }

    #[Route('/album/{album_id<\d+>}/publish', methods: 'PATCH')]
    #[UserRolePermission(RolePermissionEnum::ALBUM_STATUS_CONTROL_TO_USER)]
    public function publish(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        PublishAlbumService $publishAlbumService
    ): JsonResponse {
        return $publishAlbumService->request($album);
    }
}