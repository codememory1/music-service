<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\ResponseTypeEnum;
use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Role.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[ORM\Table('roles')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('key', message: 'role@exist', payload: [ResponseTypeEnum::EXIST, 409])]
class Role implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

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

    #[ORM\OneToMany(mappedBy: 'role', targetEntity: RolePermission::class, cascade: ['persist', 'remove'])]
    private Collection $permissions;

    #[Pure]
    public function __construct()
    {
        $this->permissions = new ArrayCollection();
    }

    /**
     * @return null|string
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param null|string $key
     *
     * @return $this
     */
    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->titleTranslationKey;
    }

    public function setTitle(?string $titleTranslationKey): self
    {
        $this->titleTranslationKey = $titleTranslationKey;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getShortDescription(): ?string
    {
        return $this->shortDescriptionTranslationKey;
    }

    /**
     * @param null|string $shortDescriptionTranslationKey
     *
     * @return $this
     */
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
     * @param RolePermission $permission
     *
     * @return $this
     */
    public function addPermission(RolePermission $permission): self
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions[] = $permission;
            $permission->setRole($this);
        }

        return $this;
    }

    /**
     * @param RolePermission $permission
     *
     * @return $this
     */
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
