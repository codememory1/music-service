<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class SubscriptionOptionNameEntity
 *
 * @package App\Orm\Entities
 */
#[ORM\Entity(tableName: 'subscription_option_names')]
#[ORM\Repository(repository: 'App\Orm\Repositories\SubscriptionOptionNameRepository')]
class SubscriptionOptionNameEntity
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
    #[ORM\Column(name: 'name', type: 'varchar', length: 50, nullable: false)]
    #[ORM\Unique]
    private mixed $name = null;

	/**
	 * @var mixed
	 */
    #[ORM\Column(name: 'title', type: 'varchar', length: 255, nullable: false)]
    private mixed $title = null;

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
    public function setTitle(mixed $value): static
    {
    
		$this->title = $value;
		
		return $this;
    
    }

	/**
	 * @return mixed
	 */
    public function getTitle(): mixed
    {
    
		return $this->title;
    
    }

}