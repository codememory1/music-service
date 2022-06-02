<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\AlbumTypeDTO;
use App\Entity\AlbumType;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\AlbumType\CreateAlbumTypeService;
use App\Service\AlbumType\DeleteAlbumTypeService;
use App\Service\AlbumType\UpdateAlbumTypeService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AlbumTypeController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/album-type')]
class AlbumTypeController extends AbstractRestController
{
    /**
     * @param AlbumTypeDTO           $albumTypeDTO
     * @param CreateAlbumTypeService $createAlbumTypeService
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::CREATE_ALBUM_TYPE)]
    public function create(AlbumTypeDTO $albumTypeDTO, CreateAlbumTypeService $createAlbumTypeService): JsonResponse
    {
        return $createAlbumTypeService->make($albumTypeDTO->collect());
    }

    /**
     * @param AlbumType              $albumType
     * @param AlbumTypeDTO           $albumTypeDTO
     * @param UpdateAlbumTypeService $updateAlbumTypeService
     *
     * @return JsonResponse
     */
    #[Route('/{albumType_id<\d+>}/edit', methods: 'PUT')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::UPDATE_ALBUM_TYPE)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'albumType')] AlbumType $albumType,
        AlbumTypeDTO $albumTypeDTO,
        UpdateAlbumTypeService $updateAlbumTypeService
    ): JsonResponse {
        $albumTypeDTO->setEntity($albumType);

        return $updateAlbumTypeService->make($albumTypeDTO->collect());
    }

    /**
     * @param AlbumType              $albumType
     * @param DeleteAlbumTypeService $deleteAlbumTypeService
     *
     * @return JsonResponse
     */
    #[Route('/{albumType_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::DELETE_ALBUM_TYPE)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'albumType')] AlbumType $albumType,
        DeleteAlbumTypeService $deleteAlbumTypeService
    ): JsonResponse {
        return $deleteAlbumTypeService->make($albumType);
    }
}