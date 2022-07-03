<?php

namespace App\Service\UserRole;

use App\Entity\Role;
use App\Repository\RolePermissionKeyRepository;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class SetPermissionsToRoleService.
 *
 * @package App\Service\UserRole
 *
 * @author  Codememory
 */
class SetPermissionsToRoleService
{
    #[Required]
    public ?RolePermissionKeyRepository $rolePermissionKeyRepository = null;

    public function set(Role $role, array $permissionKeys): void
    {
        $rolePermissionKeys = [];

        foreach ($permissionKeys as $permissionKey) {
            $rolePermissionKey = $this->rolePermissionKeyRepository->findOneBy([
                'key' => $permissionKey
            ]);

            if (null === $rolePermissionKey) {
                throw EntityNotFoundException::rolePermissionKey();
            }

            $rolePermissionKeys[] = $rolePermissionKey;
        }

        $role->setPermissions($rolePermissionKeys);
    }
}