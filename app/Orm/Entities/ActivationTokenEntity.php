<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;
use Codememory\Components\Database\Orm\Interfaces\RelationshipInterface;
use Codememory\Components\Database\Schema\StatementComponents\ReferenceDefinition;

/**
 * Class ActivationTokenEntity
 *
 * @package App\Orm\Entities
 */
#[ORM\Entity(tableName: 'activation_tokens')]
#[ORM\Repository(repository: 'App\Orm\Repositories\ActivationTokenRepository')]
class ActivationTokenEntity
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
    #[ORM\Reference(entity: UserEntity::class, referencedColumnName: 'id', on: [RelationshipInterface::ON_DELETE], onOptions: [ReferenceDefinition::RD_CASCADE])]
    private mixed $user_id = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'token', type: 'text', length: null, nullable: false)]
    private mixed $token = null;

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
    public function setToken(mixed $value): static
    {
    
		$this->token = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getToken(): mixed
    {
    
		return $this->token;
    
    }

}