<?php

namespace App\Service\UserRole;

use App\DTO\UserRoleDTO;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class CreateUserRoleService.
 *
 * @package App\Service\UserRole
 *
 * @author  Codememory
 */
class CreateUserRoleService extends AbstractService
{
    #[Required]
    public ?SetPermissionsToRoleService $setPermissionsToRoleService = null;

    public function make(UserRoleDTO $userRoleDTO): JsonResponse
    {
        if (true !== $response = $this->validateFullDTO($userRoleDTO)) {
            return $response;
        }

        $role = $userRoleDTO->getEntity();

        $this->setPermissionsToRoleService->set($role, $userRoleDTO->permissions);

        $this->flusherService->save($role);

        return $this->responseCollection->successCreate('role@successCreate');
    }
}