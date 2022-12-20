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
use App\UseCase\User\Role\CreateUserRole;
use App\UseCase\User\Role\DeleteUserRole;
use App\UseCase\User\Role\UpdateUserRole;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/role')]
#[Authorization]
class UserRoleController extends AbstractRestController
{
    #[Route('/all', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_ROLES)]
    public function all(UserRoleResponseData $responseData, RoleRepository $roleRepository): JsonResponse
    {
        return $this->responseData($responseData, $roleRepository->findAll());
    }

    #[Route('/{role_id<\d+>}/read', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_ROLES)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'role')] Role $role,
        UserRoleResponseData $responseData
    ): JsonResponse {
        return $this->responseData($responseData, $role);
    }

    #[Route('/create', methods: Request::METHOD_POST)]
    #[UserRolePermission(RolePermissionEnum::CREATE_USER_ROLE)]
    public function create(UserRoleTransformer $transformer, CreateUserRole $createUserRole, UserRoleResponseData $responseData): JsonResponse
    {
        return $this->responseData(
            $responseData,
            $createUserRole->process($transformer->transformFromRequest()),
            PlatformCodeEnum::CREATED
        );
    }

    #[Route('/{role_id<\d+>}/edit', methods: Request::METHOD_PUT)]
    #[UserRolePermission(RolePermissionEnum::UPDATE_USER_ROLE)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'role')] Role $role,
        UserRoleTransformer $transformer,
        UpdateUserRole $updateUserRole,
        UserRoleResponseData $responseData
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $updateUserRole->process($transformer->transformFromRequest($role)),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/{role_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[UserRolePermission(RolePermissionEnum::DELETE_USER_ROLE)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'role')] Role $role,
        DeleteUserRole $deleteUserRole,
        UserRoleResponseData $responseData
    ): JsonResponse {
        return $this->responseData($responseData, $deleteUserRole->process($role), PlatformCodeEnum::DELETED);
    }
}