<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\RolePermissionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class RolePermission.
 *
 * @package App\Entity
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

    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'permissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role = null;

    #[ORM\ManyToOne(targetEntity: RolePermissionKey::class, cascade: ['persist'])]
    private ?RolePermissionKey $rolePermissionKey = null;

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getPermissionKey(): ?RolePermissionKey
    {
        return $this->rolePermissionKey;
    }

    public function setPermissionKey(?RolePermissionKey $rolePermissionKey): self
    {
        $this->rolePermissionKey = $rolePermissionKey;

        return $this;
    }
}
