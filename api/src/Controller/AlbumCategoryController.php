<?php

namespace App\Controller;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\DTO\AlbumCategoryDTO;
use App\Entity\AlbumCategory;
use App\Enum\RoleEnum;
use App\Enum\RolePermissionNameEnum;
use App\Rest\ApiController;
use App\Security\Authenticator\Authenticator;
use App\Service\AlbumCategory\CreatorAlbumCategoryService;
use App\Service\AlbumCategory\DeleterAlbumCategoryService;
use App\Service\AlbumCategory\UpdaterAlbumCategoryService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AlbumCategoryController.
 *
 * @package App\Controller
 *
 * @author  Codememory
 */
#[Route('/album/category')]
class AlbumCategoryController extends ApiController
{

    /**
     * @param Authenticator $authenticator
     *
     * @return JsonResponse
     */
    #[Route('/all', methods: 'GET')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::SHOW_ALBUM_CATEGORIES)]
    public function all(Authenticator $authenticator): JsonResponse
    {
        return $this->findAllResponse(AlbumCategory::class, AlbumCategoryDTO::class);
    }
}