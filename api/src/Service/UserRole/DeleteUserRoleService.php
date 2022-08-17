<?php

namespace App\Service\UserRole;

use App\Entity\Role;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteUserRoleService extends AbstractService
{
    public function delete(Role $role): Role
    {
        $this->flusherService->remove($role);

        return $role;
    }

    public function request(Role $role): JsonResponse
    {
        $this->delete($role);

        return $this->responseCollection->successDelete('role@successDelete');
    }
}