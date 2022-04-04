<?php

namespace App\Controller;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\DTO\AlbumTypeDTO;
use App\Entity\AlbumType;
use App\Enum\RolePermissionNameEnum;
use App\Rest\ApiController;
use App\Service\Album\Type\CreatorAlbumTypeService;
use App\Service\Album\Type\DeleterAlbumTypeService;
use App\Service\Album\Type\UpdaterAlbumTypeService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AlbumTypeController.
 *
 * @package App\Controller
 *
 * @author  Codememory
 */
#[Route('/album/type')]
class AlbumTypeController extends ApiController
{
    /**
     * @return JsonResponse
     */
    #[Route('/all', methods: 'GET')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::SHOW_ALBUM_TYPES)]
    public function all(): JsonResponse
    {
        return $this->showAllFromDatabase(
            AlbumType::class,
            AlbumTypeDTO::class
        );
    }

    /**
     * @param CreatorAlbumTypeService $creatorAlbumTypeService
     * @param AlbumTypeDTO            $albumTypeDTO
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::CREATE_ALBUM_TYPE)]
    public function create(CreatorAlbumTypeService $creatorAlbumTypeService, AlbumTypeDTO $albumTypeDTO): JsonResponse
    {
        return $creatorAlbumTypeService->create($albumTypeDTO)->make();
    }

    /**
     * @param UpdaterAlbumTypeService $updaterAlbumTypeService
     * @param AlbumTypeDTO            $albumTypeDTO
     * @param int                     $id
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/edit', methods: 'PUT')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::UPDATE_ALBUM_TYPE)]
    public function update(UpdaterAlbumTypeService $updaterAlbumTypeService, AlbumTypeDTO $albumTypeDTO, int $id): JsonResponse
    {
        return $updaterAlbumTypeService->update($albumTypeDTO, $id)->make();
    }

    /**
     * @param DeleterAlbumTypeService $deleterAlbumTypeService
     * @param int                     $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/delete', methods: 'DELETE')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::DELETE_ALBUM_TYPE)]
    public function delete(DeleterAlbumTypeService $deleterAlbumTypeService, int $id): JsonResponse
    {
        return $deleterAlbumTypeService->delete($id)->make();
    }
}