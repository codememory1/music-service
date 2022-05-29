<?php

namespace App\Service\UserRole;

use App\DTO\UserRoleDTO;
use App\Entity\Role;
use App\Entity\RolePermission;
use App\Repository\RolePermissionKeyRepository;
use App\Rest\Http\Exceptions\EntityNotFoundException;
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
    public ?RolePermissionKeyRepository $rolePermissionKeyRepository = null;

    /**
     * @param UserRoleDTO $userRoleDTO
     *
     * @return JsonResponse
     */
    public function make(UserRoleDTO $userRoleDTO): JsonResponse
    {
        if (false === $this->validate($userRoleDTO)) {
            return $this->validator->getResponse();
        }

        $roleEntity = $userRoleDTO->getEntity();

        if (false === $this->validate($roleEntity)) {
            return $this->validator->getResponse();
        }

        $this->addPermission($roleEntity, $userRoleDTO->permissions);

        $this->em->persist($roleEntity);
        $this->em->flush();

        return $this->responseCollection->successCreate('role@successCreate');
    }

    /**
     * @param Role  $role
     * @param array $permissionKeys
     *
     * @return void
     */
    public function addPermission(Role $role, array $permissionKeys): void
    {
        foreach ($permissionKeys as $permission) {
            $rolePermissionKey = $this->rolePermissionKeyRepository->findOneBy([
                'key' => $permission
            ]);

            if (null === $rolePermissionKey) {
                throw EntityNotFoundException::rolePermissionKey();
            }

            $rolePermissionEntity = new RolePermission();

            $rolePermissionEntity->setPermissionKey($rolePermissionKey);

            $role->addPermission($rolePermissionEntity);
        }
    }
}