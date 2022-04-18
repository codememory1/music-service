<?php

namespace App\Controller\Admin;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\DTO\AlbumCategoryDTO;
use App\Enum\RolePermissionNameEnum;
use App\Service\AlbumCategory\CreatorAlbumCategoryService;
use App\Service\AlbumCategory\DeleterAlbumCategoryService;
use App\Service\AlbumCategory\UpdaterAlbumCategoryService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AlbumCategoryController
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/album/category')]
class AlbumCategoryController
{
    /**
     * @param CreatorAlbumCategoryService $creatorAlbumCategoryService
     * @param AlbumCategoryDTO            $albumCategoryDTO
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::CREATE_ALBUM_CATEGORY)]
    public function create(
        CreatorAlbumCategoryService $creatorAlbumCategoryService,
        AlbumCategoryDTO $albumCategoryDTO
    ): JsonResponse
    {
        return $creatorAlbumCategoryService->create($albumCategoryDTO)->make();
    }

    /**
     * @param UpdaterAlbumCategoryService $updaterAlbumCategoryService
     * @param AlbumCategoryDTO            $albumCategoryDTO
     * @param int                         $id
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/edit', methods: 'PUT')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::UPDATE_ALBUM_CATEGORY)]
    public function update(
        UpdaterAlbumCategoryService $updaterAlbumCategoryService,
        AlbumCategoryDTO $albumCategoryDTO,
        int $id
    ): JsonResponse
    {
        return $updaterAlbumCategoryService->update($albumCategoryDTO, $id)->make();
    }

    /**
     * @param DeleterAlbumCategoryService $deleterAlbumCategoryService
     * @param int                         $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/delete', methods: 'DELETE')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::DELETE_ALBUM_CATEGORY)]
    public function delete(DeleterAlbumCategoryService $deleterAlbumCategoryService, int $id): JsonResponse
    {
        return $deleterAlbumCategoryService->delete($id)->make();
    }
}