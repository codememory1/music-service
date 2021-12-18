<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

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
    #[ORM\Column(name: 'id', type: 'bigint unsigned', length: null, nullable: false)]
    #[ORM\Identifier]
    private ?int $id = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'access_right_id', type: 'bigint unsigned', length: null, nullable: false)]
    private ?int $access_right_id = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'role_id', type: 'bigint unsigned', length: null, nullable: false)]
    private ?int $role_id = null;

    /**
     * @var AccessRightNameEntity|null
     */
    #[ORM\Join(entity: AccessRightNameEntity::class, columns: ['right_name', 'arn_id'], as: ['name', 'id'])]
    private ?AccessRightNameEntity $accessRightName = null;

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
    public function setAccessRightId(int $value): static
    {

        $this->access_right_id = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getAccessRightId(): ?int
    {

        return $this->access_right_id;

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

    /**
     * @return AccessRightNameEntity|null
     */
    public function getAccessRightName(): ?AccessRightNameEntity
    {

        return $this->accessRightName;

    }

}