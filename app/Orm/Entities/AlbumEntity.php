<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;
use Codememory\Components\Database\Orm\Interfaces\RelationshipInterface;
use Codememory\Components\Database\Schema\StatementComponents\ReferenceDefinition;

/**
 * Class AlbumEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'albums')]
#[ORM\Repository(repository: 'App\Orm\Repositories\AlbumRepository')]
class AlbumEntity
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
    #[ORM\Column(name: 'name', type: 'varchar', length: 255, nullable: false)]
    private ?string $name = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'type_id', type: 'bigint unsigned', length: null, nullable: false)]
    #[ORM\Reference(
        entity: AlbumTypeEntity::class,
        referencedColumnName: 'id',
        on: [RelationshipInterface::ON_DELETE],
        onOptions: [ReferenceDefinition::RD_CASCADE]
    )]
    private ?int $type_id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'created_at', type: 'datetime', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'CURRENT_TIMESTAMP')]
    private ?string $created_at = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'updated_at', type: 'datetime', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'CURRENT_TIMESTAMP')]
    private ?string $updated_at = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
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
     * @return string|null
     */
    public function getName(): ?string
    {

        return $this->name;

    }

    /**
     * @param int $value
     *
     * @return static
     */
    public function setTypeId(int $value): static
    {

        $this->type_id = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getTypeId(): ?int
    {

        return $this->type_id;

    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {

        return $this->created_at;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setUpdatedAt(string $value): static
    {

        $this->updated_at = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {

        return $this->updated_at;

    }

}