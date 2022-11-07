<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\UserRoleTransformer;
use App\Entity\Role;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\RoleRepository;
use App\ResponseData\UserRoleResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\UserRole\CreateUserRoleService;
use App\Service\UserRole\DeleteUserRoleService;
use App\Service\UserRole\UpdateUserRoleService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/role')]
#[Authorization]
class UserRoleController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::SHOW_ROLES)]
    public function all(UserRoleResponseData $userRoleResponseData, RoleRepository $roleRepository): JsonResponse
    {
        $userRoleResponseData->setEntities($roleRepository->findAll());

        return $this->responseData($userRoleResponseData);
    }

    #[Route('/{role_id<\d+>}/read', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::SHOW_ROLES)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'role')] Role $role,
        UserRoleResponseData $userRoleResponseData
    ): JsonResponse {
        $userRoleResponseData->setEntities($role);

        return $this->responseData($userRoleResponseData);
    }

    #[Route('/create', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::CREATE_USER_ROLE)]
    public function create(UserRoleTransformer $userRoleTransformer, CreateUserRoleService $createUserRoleService): JsonResponse
    {
        return $createUserRoleService->request($userRoleTransformer->transformFromRequest());
    }

    #[Route('/{role_id<\d+>}/edit', methods: 'PUT')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_USER_ROLE)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'role')] Role $role,
        UserRoleTransformer $userRoleTransformer,
        UpdateUserRoleService $updateUserRoleService
    ): JsonResponse {
        return $updateUserRoleService->request($userRoleTransformer->transformFromRequest($role));
    }

    #[Route('/{role_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_USER_ROLE)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'role')] Role $role,
        DeleteUserRoleService $deleteUserRoleService
    ): JsonResponse {
        return $deleteUserRoleService->request($role);
    }
}