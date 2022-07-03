<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Entity\User;
use App\Enum\RolePermissionEnum;
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
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/user')]
class AlbumController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/album/all', methods: 'GET')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::SHOW_FULL_INFO_ALBUMS)]
    public function all(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        AlbumResponseData $albumResponseData,
        AlbumRepository $albumRepository
    ): JsonResponse {
        $albumResponseData->setEntities($albumRepository->findAllByUser($user));
        $albumResponseData->collect();

        return $this->responseCollection->dataOutput($albumResponseData->getResponse());
    }

    #[Route('/{user_id<\d+>}/album/create', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::CREATE_ALBUM_TO_USER)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        AlbumDTO $albumDTO,
        CreateAlbumService $createAlbumService
    ): JsonResponse {
        return $createAlbumService->make($albumDTO->collect(), $user);
    }

    #[Route('/album/{album_id<\d+>}/edit', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::UPDATE_ALBUM_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        AlbumDTO $albumDTO,
        UpdateAlbumService $updateAlbumService
    ): JsonResponse {
        $albumDTO->setEntity($album);

        return $updateAlbumService->make($albumDTO->collect(), $album->getUser());
    }

    #[Route('/album/{album_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::DELETE_ALBUM_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        DeleteAlbumService $deleteAlbumService
    ): JsonResponse {
        return $deleteAlbumService->make($album);
    }

    #[Route('/album/{album_id<\d+>}/publish', methods: 'PATCH')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::ALBUM_STATUS_CONTROL_TO_USER)]
    public function publication(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        PublishAlbumService $publishAlbumService
    ): JsonResponse {
        return $publishAlbumService->make($album);
    }
}