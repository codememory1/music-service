<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;
use Codememory\Components\Database\Orm\Interfaces\RelationshipInterface;
use Codememory\Components\Database\Schema\StatementComponents\ReferenceDefinition;

/**
 * Class RoleRightEntity
 *
 * @package App\Orm\Entities
 */
#[ORM\Entity(tableName: 'role_rights')]
#[ORM\Repository(repository: 'App\Orm\Repositories\RoleRightRepository')]
class RoleRightEntity
{

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'id', type: 'int', length: null, nullable: false)]
    #[ORM\Identifier]
    private ?int $id = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'access_right', type: 'int', length: null, nullable: false)]
    #[ORM\Reference(
        entity: AccessRightNameEntity::class,
        referencedColumnName: 'id',
        on: [RelationshipInterface::ON_DELETE],
        onOptions: [ReferenceDefinition::RD_CASCADE]
    )]
    private ?int $access_right = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'role_id', type: 'int', length: null, nullable: false)]
    #[ORM\Reference(
        entity: RoleEntity::class,
        referencedColumnName: 'id',
        on: [RelationshipInterface::ON_DELETE],
        onOptions: [ReferenceDefinition::RD_CASCADE]
    )]
    private ?int $role_id = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * @param int $value
     *
     * @return static
     */
    public function setAccessRight(int $value): static
    {

        $this->access_right = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getAccessRight(): ?int
    {

        return $this->access_right;

    }

    /**
     * @param int $value
     *
     * @return static
     */
    public function setRoleId(int $value): static
    {

        $this->role_id = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getRoleId(): ?int
    {

        return $this->role_id;

    }

}