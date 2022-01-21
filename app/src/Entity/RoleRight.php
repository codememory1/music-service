<?php

namespace App\Entity;

use App\Repository\RoleRightRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class RoleRight
 *
 * @package App\Entitiy
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: RoleRightRepository::class)]
#[ORM\Table('role_rights')]
class RoleRight
{

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var RoleRightName|null
     */
    #[ORM\ManyToOne(targetEntity: RoleRightName::class, inversedBy: 'roleRights')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RoleRightName $roleRightName = null;

    /**
     * @var Role|null
     */
    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'roleRights')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * @return RoleRightName|null
     */
    public function getRoleRightName(): ?RoleRightName
    {

        return $this->roleRightName;

    }

    /**
     * @param RoleRightName|null $roleRightName
     *
     * @return $this
     */
    public function setRoleRightName(?RoleRightName $roleRightName): self
    {

        $this->roleRightName = $roleRightName;

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
