<?php

namespace App\Service\UserRole;

use App\DTO\UserRoleDTO;
use App\Entity\Role;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class UpdateUserRoleService.
 *
 * @package App\Service\UserRole
 *
 * @author  Codememory
 */
class UpdateUserRoleService extends AbstractService
{
    #[Required]
    public ?SetPermissionsToRoleService $setPermissionsToRoleService = null;

    public function make(UserRoleDTO $userRoleDTO, Role $role): JsonResponse
    {
        if (true !== $response = $this->validateFullDTO($userRoleDTO)) {
            return $response;
        }

        $this->setPermissionsToRoleService->set($role, $userRoleDTO->permissions);

        $this->flusherService->save();

        return $this->responseCollection->successCreate('role@successUpdate');
    }
}