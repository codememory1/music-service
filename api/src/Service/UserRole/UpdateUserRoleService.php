<?php

namespace App\Service\UserRole;

use App\Dto\Transfer\UserRoleDto;
use App\Entity\Role;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UpdateUserRoleService.
 *
 * @package App\Service\UserRole
 *
 * @author  Codememory
 */
class UpdateUserRoleService extends AbstractService
{
    public function update(UserRoleDto $userRoleDto): Role
    {
        $this->validateWithEntity($userRoleDto);

        $this->flusherService->save();

        return $userRoleDto->getEntity();
    }

    public function request(UserRoleDto $userRoleDto): JsonResponse
    {
        $this->update($userRoleDto);

        return $this->responseCollection->successCreate('role@successUpdate');
    }
}