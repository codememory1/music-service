<?php

namespace App\Service\UserRole;

use App\Entity\Role;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeleteUserRoleService.
 *
 * @package App\Service\UserRole
 *
 * @author  Codememory
 */
class DeleteUserRoleService extends AbstractService
{
    public function make(Role $role): JsonResponse
    {
        $this->flusherService->addRemove($role)->save();

        return $this->responseCollection->successDelete('role@successDelete');
    }
}