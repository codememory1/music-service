<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class UsersEntity
 *
 * @package App\Orm\Entities
 */
#[ORM\Entity(tableName: 'users')]
#[ORM\Repository(repository: 'App\Orm\Repositories\UsersRepository')]
class UsersEntity
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
    #[ORM\Column(name: 'userid', type: 'int', length: null, nullable: false)]
    private mixed $userid = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'email', type: 'varchar', length: 255, nullable: false)]
    private mixed $email = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'username', type: 'varchar', length: 255, nullable: false)]
    private mixed $username = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'password', type: 'text', length: null, nullable: false)]
    private mixed $password = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'surname', type: 'varchar', length: 32, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private mixed $surname = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'patronymic', type: 'varchar', length: 32, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private mixed $patronymic = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'birth', type: 'date', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private mixed $birth = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'subscription', type: 'int', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private mixed $subscription = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'role', type: 'int', length: null, nullable: false)]
    #[ORM\DefaultValue(value: '1')]
    private mixed $role = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'status', type: 'int', length: null, nullable: false)]
    #[ORM\DefaultValue(value: '0')]
    #[ORM\Reference(entity: RoleEntity::class, referencedColumnName: 'id')]
    private mixed $status = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'activation_token', type: 'text', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private mixed $activation_token = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'created_at', type: 'datetime', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'CURRENT_TIMESTAMP')]
    private mixed $created_at = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'updated_at', type: 'datetime', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'CURRENT_TIMESTAMP')]
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
    public function setUserid(mixed $value): static
    {
    
		$this->userid = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getUserid(): mixed
    {
    
		return $this->userid;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setEmail(mixed $value): static
    {
    
		$this->email = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getEmail(): mixed
    {
    
		return $this->email;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setUsername(mixed $value): static
    {
    
		$this->username = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getUsername(): mixed
    {
    
		return $this->username;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setPassword(mixed $value): static
    {
    
		$this->password = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getPassword(): mixed
    {
    
		return $this->password;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setSurname(mixed $value): static
    {
    
		$this->surname = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getSurname(): mixed
    {
    
		return $this->surname;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setPatronymic(mixed $value): static
    {
    
		$this->patronymic = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getPatronymic(): mixed
    {
    
		return $this->patronymic;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setBirth(mixed $value): static
    {
    
		$this->birth = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getBirth(): mixed
    {
    
		return $this->birth;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setSubscription(mixed $value): static
    {
    
		$this->subscription = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getSubscription(): mixed
    {
    
		return $this->subscription;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setRole(mixed $value): static
    {
    
		$this->role = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getRole(): mixed
    {
    
		return $this->role;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setStatus(mixed $value): static
    {
    
		$this->status = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getStatus(): mixed
    {
    
		return $this->status;
    
    }

	/**
	 * @param mixed $value
	 * @return static
	 */
    public function setActivationToken(mixed $value): static
    {
    
		$this->activation_token = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getActivationToken(): mixed
    {
    
		return $this->activation_token;
    
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