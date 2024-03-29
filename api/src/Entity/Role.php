<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\PlatformCodeEnum;
use App\Infrastructure\Validator\Validator;
use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[ORM\Table('roles')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('key', message: 'role@exist', payload: [Validator::PPC => PlatformCodeEnum::ENTITY_FOUND])]
class Role implements EntityInterface
{
    use IdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, options: [
        'comment' => 'Unique processing key'
    ])]
    private ?string $key = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'The name of this role as a translation key'
    ])]
    private ?string $titleTranslationKey = null;

    #[ORM\Column(type: Types::STRING, length: 300, options: [
        'comment' => 'Brief description of this role in the form of a translation key'
    ])]
    private ?string $shortDescriptionTranslationKey = null;

    #[ORM\OneToMany(mappedBy: 'role', targetEntity: RolePermission::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $permissions;

    #[Pure]
    public function __construct()
    {
        $this->permissions = new ArrayCollection();
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->titleTranslationKey;
    }

    public function setTitle(?string $titleTranslationKey): self
    {
        $this->titleTranslationKey = $titleTranslationKey;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescriptionTranslationKey;
    }

    public function setShortDescription(?string $shortDescriptionTranslationKey): self
    {
        $this->shortDescriptionTranslationKey = $shortDescriptionTranslationKey;

        return $this;
    }

    /**
     * @return Collection<int, RolePermission>
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    /**
     * @param array<RolePermissionKey> $permissionKeys
     */
    public function setPermissions(array $permissionKeys): self
    {
        $permissions = [];

        foreach ($permissionKeys as $permissionsKey) {
            $rolePermission = new RolePermission();

            $rolePermission->setRole($this);
            $rolePermission->setPermissionKey($permissionsKey);

            $permissions[] = $rolePermission;
        }

        $this->permissions = new ArrayCollection($permissions);

        return $this;
    }

    public function addPermission(RolePermission $permission): self
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions[] = $permission;
            $permission->setRole($this);
        }

        return $this;
    }

    public function removePermission(RolePermission $permission): self
    {
        if ($this->permissions->removeElement($permission)) {
            // set the owning side to null (unless already changed)
            if ($permission->getRole() === $this) {
                $permission->setRole(null);
            }
        }

        return $this;
    }
}
