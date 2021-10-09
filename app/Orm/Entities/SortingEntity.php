<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class SortingEntity
 *
 * @package App\Orm\Entities
 */
#[ORM\Entity(tableName: 'sorting')]
#[ORM\Repository(repository: 'App\Orm\Repositories\SortingRepository')]
class SortingEntity
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
    #[ORM\Column(name: 'table', type: 'varchar', length: 64, nullable: false)]
    #[ORM\Unique]
    private mixed $table = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'columns', type: 'json', length: null, nullable: false)]
    private mixed $columns = null;

	/**
	 * @return mixed
	 */
    public function getId(): mixed
    {
    
		return $this->id;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setTable(mixed $value): static
    {
    
		$this->table = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getTable(): mixed
    {
    
		return $this->table;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setColumns(mixed $value): static
    {
    
		$this->columns = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getColumns(): mixed
    {
    
		return $this->columns;
    
    }

}