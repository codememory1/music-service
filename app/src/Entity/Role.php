<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * Class Role
 *
 * @package App\Entitiy
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[ORM\Table('roles')]
class Role
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column('`key`', 'string', length: 255, unique: true, options: [
        'comment' => 'Unique role key against which the role will be checked'
    ])]
    private ?string $key = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, options: [
        'comment' => 'Role name translation key'
    ])]
    private ?string $titleTranslationKey = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'role', targetEntity: RolePermission::class)]
    private Collection $rolePermissions;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'role', targetEntity: User::class)]
    private Collection $users;

    #[Pure]
    public function __construct()
    {
        $this->rolePermissions = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

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
    public function addRoleRight(RolePermission $rolePermission): self
    {

        if (!$this->rolePermissions->contains($rolePermission)) {
            $this->rolePermissions[] = $rolePermission;
            $rolePermission->setRole($this);
        }

        return $this;

    }

    /**
     * @param RolePermission $rolePermission
     *
     * @return $this
     */
    public function removeRoleRight(RolePermission $rolePermission): self
    {

        if ($this->rolePermissions->removeElement($rolePermission)) {
            if ($rolePermission->getRole() === $this) {
                $rolePermission->setRole(null);
            }
        }

        return $this;

    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {

        return $this->users;

    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function addUser(User $user): self
    {

        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setRole($this);
        }

        return $this;

    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function removeUser(User $user): self
    {

        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getRole() === $this) {
                $user->setRole(null);
            }
        }

        return $this;

    }

}
