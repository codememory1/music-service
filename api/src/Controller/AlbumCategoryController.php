<?php

namespace App\Controller;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\DTO\AlbumCategoryDTO;
use App\Entity\AlbumCategory;
use App\Enum\RolePermissionNameEnum;
use App\Rest\ApiController;
use App\Security\Authenticator\Authenticator;
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