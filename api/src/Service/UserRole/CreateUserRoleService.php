<?php

namespace App\Service\UserRole;

use App\Dto\Transfer\UserRoleDto;
use App\Entity\Role;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CreateUserRoleService.
 *
 * @package App\Service\UserRole
 *
 * @author  Codememory
 */
class CreateUserRoleService extends AbstractService
{
    public function create(UserRoleDto $userRoleDto): Role
    {
        $this->validateWithEntity($userRoleDto);

        $role = $userRoleDto->getEntity();

        $this->flusherService->save($role);

        return $role;
    }

    public function request(UserRoleDto $userRoleDto): JsonResponse
    {
        $this->create($userRoleDto);

        return $this->responseCollection->successCreate('role@successCreate');
    }
}