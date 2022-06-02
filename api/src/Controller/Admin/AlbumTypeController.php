<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\UserRolePermission;
use App\DTO\AlbumTypeDTO;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Service\AlbumType\CreateAlbumTypeService;
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
}