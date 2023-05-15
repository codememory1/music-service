<?php

namespace App\Entity;

use App\Repository\PermissionRepository;
use Codememory\ApiBundle\Entity\Interfaces\EntityInterface;
use Codememory\ApiBundle\Entity\Traits\CreatedAtTrait;
use Codememory\ApiBundle\Entity\Traits\IdentifierTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermissionRepository::class)]
#[ORM\Table('permissions')]
#[ORM\HasLifecycleCallbacks]
class Permission implements EntityInterface
{
    use IdentifierTrait;
    use CreatedAtTrait;

    #[ORM\Column(length: 255)]
    private ?string $key = null;

    #[ORM\OneToMany(mappedBy: 'permission', targetEntity: RolePermission::class, cascade: ['remove'])]
    private Collection $rolePermissions;

    public function __construct()
    {
        $this->rolePermissions = new ArrayCollection();
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return Collection<int, RolePermission>
     */
    public function getRolePermissions(): Collection
    {
        return $this->rolePermissions;
    }

    public function addRolePermission(RolePermission $rolePermission): self
    {
        if (!$this->rolePermissions->contains($rolePermission)) {
            $this->rolePermissions->add($rolePermission);
            $rolePermission->setPermission($this);
        }

        return $this;
    }

    public function removeRolePermission(RolePermission $rolePermission): self
    {
        if ($this->rolePermissions->removeElement($rolePermission)) {
            // set the owning side to null (unless already changed)
            if ($rolePermission->getPermission() === $this) {
                $rolePermission->setPermission(null);
            }
        }

        return $this;
    }
}
