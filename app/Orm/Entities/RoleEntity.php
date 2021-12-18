<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class RoleEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'roles')]
#[ORM\Repository(repository: 'App\Orm\Repositories\RoleRepository')]
class RoleEntity
{

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'id', type: 'bigint unsigned', length: null, nullable: false)]
    #[ORM\Identifier]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'name', type: 'varchar', length: 100, nullable: false)]
    #[ORM\Unique]
    private ?string $name = null;

    /**
     * @var RoleRightEntity[]
     */
    private array $rights = [];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setName(string $value): static
    {

        $this->name = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {

        return $this->name;

    }

    /**
     * @param RoleRightEntity[] $rights
     *
     * @return static
     */
    public function setRights(array $rights): static
    {

        $this->rights = $rights;

        return $this;

    }

    /**
     * @return RoleRightEntity[]
     */
    public function getRights(): array
    {

        return $this->rights;

    }

}