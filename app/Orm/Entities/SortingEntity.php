<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class SortingEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'sorting')]
#[ORM\Repository(repository: 'App\Orm\Repositories\SortingRepository')]
class SortingEntity
{

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'id', type: 'int', length: null, nullable: false)]
    #[ORM\Identifier]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'table', type: 'varchar', length: 64, nullable: false)]
    #[ORM\Unique]
    private ?string $table = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'columns', type: 'json', length: null, nullable: false)]
    private ?string $columns = null;

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
    public function setTable(string $value): static
    {

        $this->table = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getTable(): ?string
    {

        return $this->table;

    }

    /**
     * @param array $value
     *
     * @return static
     */
    public function setColumns(array $value): static
    {

        $this->columns = json_encode($value);

        return $this;

    }

    /**
     * @param bool $asArray
     *
     * @return string|array|null
     */
    public function getColumns(bool $asArray = true): null|string|array
    {

        if ($asArray) {
            return json_decode($this->columns);
        }

        return $this->columns;

    }

}