<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\UserRolePermissionDTO;
use App\Entity\Role;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\UserRole\UpdatePermissionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserRolePermissionController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/user')]
class UserRolePermissionController extends AbstractRestController
{
    /**
     * @param Role                    $role
     * @param UserRolePermissionDTO   $userRolePermissionDTO
     * @param UpdatePermissionService $updatePermissionService
     *
     * @return JsonResponse
     */
    #[Route('/role/{role_id<\d+>}/permissions/edit')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::UPDATE_PERMISSIONS_TO_ROLE)]
    public function updateRolePermission(
        #[EntityNotFound(EntityNotFoundException::class, 'role')] Role $role,
        UserRolePermissionDTO $userRolePermissionDTO,
        UpdatePermissionService $updatePermissionService
    ): JsonResponse {
        return $updatePermissionService->make($userRolePermissionDTO->collect(), $role);
    }
}