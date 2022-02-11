<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Repository\RolePermissionNameRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * Class RolePermissionName
 *
 * @package App\Entitiy
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: RolePermissionNameRepository::class)]
#[ORM\Table('role_permission_names')]
#[ORM\HasLifecycleCallbacks]
class RolePermissionName implements EntityInterface
{

    use IdentifierTrait;
    use TimestampTrait;

    /**
     * @var string|null
     */
    #[ORM\Column('`key`', Types::STRING, length: 255, unique: true, options: [
        'comment' => 'A unique key that can be used to check availability'
    ])]
    private ?string $key = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Rule name translation key'
    ])]
    private ?string $titleTranslationKey = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'rolePermissionName', targetEntity: RolePermission::class)]
    private Collection $rolePermissions;

    #[Pure]
    public function __construct()
    {

        $this->rolePermissions = new ArrayCollection();

    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {

        return $this->key;

    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setKey(string $key): self
    {

        $this->key = $key;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getTitleTranslationKey(): ?string
    {

        return $this->titleTranslationKey;

    }

    /**
     * @param string $titleTranslationKey
     *
     * @return $this
     */
    public function setTitleTranslationKey(string $titleTranslationKey): self
    {

        $this->titleTranslationKey = $titleTranslationKey;

        return $this;

    }

    /**
     * @return Collection
     */
    public function getRolePermissions(): Collection
    {

        return $this->rolePermissions;

    }

    /**
     * @param RolePermission $rolePermission
     *
     * @return $this
     */
    public function addRolePermission(RolePermission $rolePermission): self
    {

        if (!$this->rolePermissions->contains($rolePermission)) {
            $this->rolePermissions[] = $rolePermission;
            $rolePermission->setRolePermissionName($this);
        }

        return $this;

    }

    /**
     * @param RolePermission $rolePermission
     *
     * @return $this
     */
    public function removeRolePermission(RolePermission $rolePermission): self
    {

        if ($this->rolePermissions->removeElement($rolePermission)) {
            if ($rolePermission->getRolePermissionName() === $this) {
                $rolePermission->setRolePermissionName(null);
            }
        }

        return $this;

    }

}
