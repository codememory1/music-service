<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\UserRoleDTO;
use App\Entity\Role;
use App\Enum\RolePermissionEnum;
use App\Repository\RoleRepository;
use App\ResponseData\UserRoleResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\UserRole\CreateUserRoleService;
use App\Service\UserRole\DeleteUserRoleService;
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
    #[Route('/all', methods: 'GET')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::SHOW_ROLES)]
    public function all(UserRoleResponseData $userRoleResponseData, RoleRepository $roleRepository): JsonResponse
    {
        $userRoleResponseData->setEntities($roleRepository->findAll());
        $userRoleResponseData->collect();

        return $this->responseCollection->dataOutput($userRoleResponseData->getResponse());
    }

    #[Route('/{role_id<\d+>}/read', methods: 'GET')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::SHOW_ROLES)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'role')] Role $role,
        UserRoleResponseData $userRoleResponseData
    ): JsonResponse {
        $userRoleResponseData->setEntities($role);
        $userRoleResponseData->collect();

        return $this->responseCollection->dataOutput($userRoleResponseData->getResponse());
    }

    #[Route('/create', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::CREATE_USER_ROLE)]
    public function create(UserRoleDTO $userRoleDTO, CreateUserRoleService $createUserRoleService): JsonResponse
    {
        return $createUserRoleService->make($userRoleDTO->collect());
    }

    #[Route('/{role_id<\d+>}/edit', methods: 'PUT')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::UPDATE_USER_ROLE)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'role')] Role $role,
        UserRoleDTO $userRoleDTO,
        UpdateUserRoleService $updateUserRoleService
    ): JsonResponse {
        $userRoleDTO->setEntity($role);
        $userRoleDTO->collect();

        return $updateUserRoleService->make($userRoleDTO, $role);
    }

    #[Route('/{role_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::DELETE_USER_ROLE)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'role')] Role $role,
        DeleteUserRoleService $deleteUserRoleService
    ): JsonResponse {
        return $deleteUserRoleService->make($role);
    }
}