<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class AccessRightNameEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'access_right_names')]
#[ORM\Repository(repository: 'App\Orm\Repositories\AccessRightNameRepository')]
class AccessRightNameEntity
{

    /**
     * @var null|int
     */
    #[ORM\Column(name: 'id', type: 'bigint usigned', length: null, nullable: false)]
    #[ORM\Identifier]
    private ?int $id = null;

    /**
     * @var ?string
     */
    #[ORM\Column(name: 'name', type: 'varchar', length: 50, nullable: false)]
    #[ORM\Unique]
    private ?string $name = null;

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

}