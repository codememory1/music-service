<?php

namespace App\Entity;

use App\Interfaces\EntityInterface;
use App\Repository\RolePermissionRepository;
use App\Traits\Entity\IdentifierTrait;
use App\Traits\Entity\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class RolePermission.
 *
 * @package App\Entitiy
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: RolePermissionRepository::class)]
#[ORM\Table('role_permissions')]
#[ORM\HasLifecycleCallbacks]
class RolePermission implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    /**
     * @var null|RolePermissionName
     */
    #[ORM\ManyToOne(targetEntity: RolePermissionName::class, cascade: ['persist', 'remove'], inversedBy: 'rolePermissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RolePermissionName $rolePermissionName = null;

    /**
     * @var null|Role
     */
    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'rolePermissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role = null;

    /**
     * @return null|RolePermissionName
     */
    public function getRolePermissionName(): ?RolePermissionName
    {
        return $this->rolePermissionName;
    }

    /**
     * @param null|RolePermissionName $rolePermissionName
     *
     * @return $this
     */
    public function setRolePermissionName(?RolePermissionName $rolePermissionName): self
    {
        $this->rolePermissionName = $rolePermissionName;

        return $this;
    }

    /**
     * @return null|Role
     */
    public function getRole(): ?Role
    {
        return $this->role;
    }

    /**
     * @param null|Role $role
     *
     * @return $this
     */
    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }
}
