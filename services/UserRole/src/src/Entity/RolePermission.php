<?php

namespace App\Entity;

use App\Repository\RolePermissionRepository;
use Codememory\ApiBundle\Entity\Traits\CreatedAtTrait;
use Codememory\ApiBundle\Entity\Traits\IdentifierTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RolePermissionRepository::class)]
#[ORM\Table('role_permissions')]
#[ORM\HasLifecycleCallbacks]
class RolePermission
{
    use IdentifierTrait;
    use CreatedAtTrait;

    #[ORM\ManyToOne(inversedBy: 'permissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role = null;

    #[ORM\ManyToOne(inversedBy: 'rolePermissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Permission $permission = null;

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getPermission(): ?Permission
    {
        return $this->permission;
    }

    public function setPermission(?Permission $permission): self
    {
        $this->permission = $permission;

        return $this;
    }
}
