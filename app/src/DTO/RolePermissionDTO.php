<?php

namespace App\DTO;

use App\Entity\Role;
use App\Entity\RolePermission;
use App\Entity\RolePermissionName;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class RolePermissionDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class RolePermissionDTO extends AbstractDTO
{

    /**
     * @var string|null
     */
    protected ?string $entityClass = RolePermission::class;

    /**
     * @var RolePermissionName|null
     */
    private ?RolePermissionName $rolePermissionName = null;

    /**
     * @var Role|null
     */
    private ?Role $role = null;

    /**
     * @param RolePermission $rolePermission
     * @param array          $exclude
     *
     * @return array
     */
    #[ArrayShape([
        'id'              => "int|null",
        'permission_name' => "array",
        'created_at'      => "string",
        'updated_at'      => "null|string"
    ])]
    public function toArray(RolePermission $rolePermission, array $exclude = []): array
    {

        $rolePermission = [
            'id'              => $rolePermission->getId(),
            'permission_name' => (new RolePermissionNameDTO())->toArray($rolePermission->getRolePermissionName()),
            'created_at'      => $rolePermission->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at'      => $rolePermission->getCreatedAt()?->format('Y-m-d H:i:s'),
        ];

        $this->excludeKeys($rolePermission, $exclude);

        return $rolePermission;

    }

    /**
     * @param RolePermissionName|null $rolePermissionName
     *
     * @return RolePermissionDTO
     */
    public function setRolePermissionName(?RolePermissionName $rolePermissionName): self
    {

        $this->rolePermissionName = $rolePermissionName;

        return $this;

    }

    /**
     * @return RolePermissionName|null
     */
    public function getRolePermissionName(): ?RolePermissionName
    {

        return $this->rolePermissionName;

    }

    /**
     * @param Role|null $role
     *
     * @return RolePermissionDTO
     */
    public function setRole(?Role $role): self
    {

        $this->role = $role;

        return $this;

    }

    /**
     * @return Role|null
     */
    public function getRole(): ?Role
    {

        return $this->role;

    }

}