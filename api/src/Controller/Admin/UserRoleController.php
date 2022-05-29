<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\UserRolePermission;
use App\DTO\UserRoleDTO;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Service\UserRole\CreateUserRoleService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserRoleController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/user/role')]
class UserRoleController extends AbstractRestController
{
    /**
     * @param UserRoleDTO           $userRoleDTO
     * @param CreateUserRoleService $createUserRoleService
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::CREATE_USER_ROLE)]
    public function create(UserRoleDTO $userRoleDTO, CreateUserRoleService $createUserRoleService): JsonResponse
    {
        return $createUserRoleService->make($userRoleDTO->collect());
    }
}