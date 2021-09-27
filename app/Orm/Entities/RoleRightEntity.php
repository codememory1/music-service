<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;
use \Codememory\Components\Database\Orm\Interfaces\RelationshipInterface;
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
	 * @var mixed
	 */
    #[ORM\Column(name: 'id', type: 'int', length: null, nullable: false)]
    #[ORM\Identifier]
    private mixed $id = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'access_right', type: 'int', length: null, nullable: false)]
    #[ORM\Reference(entity: AccessRightNameEntity::class, referencedColumnName: 'id', on: [RelationshipInterface::ON_DELETE], onOptions: [ReferenceDefinition::RD_CASCADE])]
    private mixed $access_right = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'role_id', type: 'int', length: null, nullable: false)]
    #[ORM\Reference(entity: RoleEntity::class, referencedColumnName: 'id', on: [RelationshipInterface::ON_DELETE], onOptions: [ReferenceDefinition::RD_CASCADE])]
    private mixed $role_id = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'allowed', type: 'tinyint', length: 1, nullable: false)]
    #[ORM\DefaultValue(value: '0')]
    private mixed $allowed = null;

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
    public function setAccessRight(mixed $value): static
    {
    
		$this->access_right = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getAccessRight(): mixed
    {
    
		return $this->access_right;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setRoleId(mixed $value): static
    {
    
		$this->role_id = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getRoleId(): mixed
    {
    
		return $this->role_id;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setAllowed(mixed $value): static
    {
    
		$this->allowed = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getAllowed(): mixed
    {
    
		return $this->allowed;
    
    }

}