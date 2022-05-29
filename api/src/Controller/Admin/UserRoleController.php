<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\UserRoleDTO;
use App\Entity\Role;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\UserRole\CreateUserRoleService;
use App\Service\UserRole\UpdateUserRoleService;
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

    /**
     * @param Role                  $role
     * @param UserRoleDTO           $userRoleDTO
     * @param UpdateUserRoleService $updateUserRoleService
     *
     * @return JsonResponse
     */
    #[Route('/{role_id<\d+>}/edit', methods: 'PUT')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::UPDATE_USER_ROLE)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'role')] Role $role,
        UserRoleDTO $userRoleDTO,
        UpdateUserRoleService $updateUserRoleService
    ): JsonResponse {
        $userRoleDTO->setEntity($role);

        return $updateUserRoleService->make($userRoleDTO->collect());
    }
}