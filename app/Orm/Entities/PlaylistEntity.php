<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class PlaylistEntity
 *
 * @package App\Orm\Entities
 */
#[ORM\Entity(tableName: 'playlists')]
#[ORM\Repository(repository: 'App\Orm\Repositories\PlaylistRepository')]
class PlaylistEntity
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
    #[ORM\Column(name: 'user_id', type: 'int', length: null, nullable: false)]
    private mixed $user_id = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'name', type: 'varchar', length: 100, nullable: false)]
    private mixed $name = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'reserved', type: 'tinyint', length: 1, nullable: false)]
    #[ORM\DefaultValue(value: '0')]
    private mixed $reserved = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'temporary', type: 'datetime', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private mixed $temporary = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'created_at', type: 'datetime', length: null, nullable: false)]
    #[ORM\DefaultValue(value: 'CURRENT_TIMESTAMP')]
    private mixed $created_at = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'updated_at', type: 'datetime', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private mixed $updated_at = null;

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
    public function setUserId(mixed $value): static
    {

        $this->user_id = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getUserId(): mixed
    {

        return $this->user_id;

    }

	/**
	 * @param mixed $value
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

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setReserved(mixed $value): static
    {
    
		$this->reserved = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getReserved(): mixed
    {
    
		return $this->reserved;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setTemporary(mixed $value): static
    {
    
		$this->temporary = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getTemporary(): mixed
    {
    
		return $this->temporary;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setCreatedAt(mixed $value): static
    {
    
		$this->created_at = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getCreatedAt(): mixed
    {
    
		return $this->created_at;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setUpdatedAt(mixed $value): static
    {
    
		$this->updated_at = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getUpdatedAt(): mixed
    {
    
		return $this->updated_at;
    
    }

}