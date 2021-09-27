<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class RoleEntity
 *
 * @package App\Orm\Entities
 */
#[ORM\Entity(tableName: 'roles')]
#[ORM\Repository(repository: 'App\Orm\Repositories\RoleRepository')]
class RoleEntity
{

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'id', type: 'int', length: null, nullable: false)]
    #[ORM\Identifier]
    private mixed $id = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'name', type: 'varchar', length: 100, nullable: false)]
    #[ORM\Unique]
    private mixed $name = null;

    /**
     * @return mixed
     */
    public function getId(): mixed
    {

        return $this->id;

    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setName(mixed $value): static
    {

        $this->name = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getName(): mixed
    {

        return $this->name;

    }

}