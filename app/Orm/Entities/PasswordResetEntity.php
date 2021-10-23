<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;
use Codememory\Components\Database\Orm\Interfaces\RelationshipInterface;
use Codememory\Components\Database\Schema\StatementComponents\ReferenceDefinition;

/**
 * Class PasswordResetEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'password_resets')]
#[ORM\Repository(repository: 'App\Orm\Repositories\PasswordResetRepository')]
class PasswordResetEntity
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
    #[ORM\Column(name: 'user_id', type: 'int', length: null, nullable: false)]
    #[ORM\Unique]
    #[ORM\Reference(
        entity: UserEntity::class,
        referencedColumnName: 'id',
        on: [RelationshipInterface::ON_DELETE],
        onOptions: [ReferenceDefinition::RD_CASCADE]
    )]
    private ?int $user_id = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'code', type: 'varchar', length: 6, nullable: false)]
    private ?int $code = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'created_at', type: 'datetime', length: null, nullable: false)]
    #[ORM\DefaultValue(value: 'CURRENT_TIMESTAMP')]
    private ?string $created_at = null;

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
    public function setUserId(int $value): static
    {

        $this->user_id = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {

        return $this->user_id;

    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setCode(int $value): static
    {

        $this->code = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {

        return $this->code;

    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {

        return $this->created_at;

    }

}