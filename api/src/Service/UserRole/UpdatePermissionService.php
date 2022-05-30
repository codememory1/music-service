<?php

namespace App\Service\UserRole;

use App\DTO\UserRolePermissionDTO;
use App\Entity\Role;
use App\Entity\RolePermission;
use App\Repository\RolePermissionKeyRepository;
use App\Repository\RolePermissionRepository;
use App\Rest\Http\Exceptions\EntityExistException;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class UpdatePermissionService.
 *
 * @package App\Service\UserRole
 *
 * @author  Codememory
 */
class UpdatePermissionService extends AbstractService
{
    #[Required]
    public ?RolePermissionKeyRepository $rolePermissionKeyRepository = null;

    #[Required]
    public ?RolePermissionRepository $rolePermissionRepository = null;

    /**
     * @param UserRolePermissionDTO $userRolePermissionDTO
     * @param Role                  $role
     *
     * @return JsonResponse
     */
    public function make(UserRolePermissionDTO $userRolePermissionDTO, Role $role): JsonResponse
    {
        $permissionsToDelete = $userRolePermissionDTO->permissions['delete'] ?? [];
        $permissionsToAdd = $userRolePermissionDTO->permissions['add'] ?? [];

        $this->add($role, $permissionsToAdd);
        $this->delete($role, $permissionsToDelete);

        $this->em->flush();

        return $this->responseCollection->successUpdate('rolePermission@successUpdatePermissionToRole');
    }

    /**
     * @param Role  $role
     * @param array $permissionsKeys
     *
     * @return void
     */
    public function delete(Role $role, array $permissionsKeys): void
    {
        foreach ($permissionsKeys as $permissionsKey) {
            $rolePermissionKey = $this->rolePermissionKeyRepository->findOneBy([
                'key' => $permissionsKey
            ]);
            $rolePermission = $this->rolePermissionRepository->findOneBy([
                'role' => $role,
                'rolePermissionKey' => $rolePermissionKey
            ]);

            if (null !== $rolePermission) {
                $this->em->remove($rolePermission);
            }
        }
    }

    /**
     * @param Role  $role
     * @param array $permissionsKeys
     *
     * @return void
     */
    public function add(Role $role, array $permissionsKeys): void
    {
        foreach ($permissionsKeys as $permissionsKey) {
            $rolePermissionKey = $this->rolePermissionKeyRepository->findOneBy([
                'key' => $permissionsKey
            ]);
            $finedRolePermission = $this->rolePermissionRepository->findOneBy([
                'role' => $role,
                'rolePermissionKey' => $rolePermissionKey
            ]);
            $rolePermission = new RolePermission();

            if (null === $rolePermissionKey) {
                throw EntityNotFoundException::rolePermissionKey();
            }

            if (null !== $finedRolePermission) {
                throw EntityExistException::rolePermission();
            }

            $rolePermission->setRole($role);
            $rolePermission->setPermissionKey($rolePermissionKey);

            $this->em->persist($rolePermission);
        }
    }
}