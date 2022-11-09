<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\UserRoleTransformer;
use App\Entity\Role;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\RoleRepository;
use App\ResponseData\General\UserRole\UserRoleResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\UserRole\CreateUserRole;
use App\Service\UserRole\DeleteUserRole;
use App\Service\UserRole\UpdateUserRole;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/role')]
#[Authorization]
class UserRoleController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::SHOW_ROLES)]
    public function all(UserRoleResponseData $responseData, RoleRepository $roleRepository): JsonResponse
    {
        $responseData->setEntities($roleRepository->findAll());

        return $this->responseData($responseData);
    }

    #[Route('/{role_id<\d+>}/read', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::SHOW_ROLES)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'role')] Role $role,
        UserRoleResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($role);

        return $this->responseData($responseData);
    }

    #[Route('/create', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::CREATE_USER_ROLE)]
    public function create(UserRoleTransformer $transformer, CreateUserRole $createUserRole, UserRoleResponseData $responseData): JsonResponse
    {
        $responseData->setEntities($createUserRole->create($transformer->transformFromRequest()));

        return $this->responseData($responseData, PlatformCodeEnum::CREATED);
    }

    #[Route('/{role_id<\d+>}/edit', methods: 'PUT')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_USER_ROLE)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'role')] Role $role,
        UserRoleTransformer $transformer,
        UpdateUserRole $updateUserRole,
        UserRoleResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($updateUserRole->update($transformer->transformFromRequest($role)));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/{role_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_USER_ROLE)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'role')] Role $role,
        DeleteUserRole $deleteUserRole,
        UserRoleResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($deleteUserRole->delete($role));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }
}