<?php

namespace App\Entity;

use App\Interfaces\EntityInterface;
use App\Repository\RolePermissionRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class RolePermission
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
     * @var RolePermissionName|null
     */
    #[ORM\ManyToOne(targetEntity: RolePermissionName::class, cascade: ['persist', 'remove'], inversedBy: 'rolePermissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RolePermissionName $rolePermissionName = null;

    /**
     * @var Role|null
     */
    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'rolePermissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role = null;

    /**
     * @return RolePermissionName|null
     */
    public function getRolePermissionName(): ?RolePermissionName
    {

        return $this->rolePermissionName;

    }

    /**
     * @param RolePermissionName|null $rolePermissionName
     *
     * @return $this
     */
    public function setRolePermissionName(?RolePermissionName $rolePermissionName): self
    {

        $this->rolePermissionName = $rolePermissionName;

        return $this;

    }

    /**
     * @return Role|null
     */
    public function getRole(): ?Role
    {

        return $this->role;

    }

    /**
     * @param Role|null $role
     *
     * @return $this
     */
    public function setRole(?Role $role): self
    {

        $this->role = $role;

        return $this;

    }

}
