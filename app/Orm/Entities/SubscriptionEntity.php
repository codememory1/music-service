<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;
use Codememory\Components\Database\Orm\Interfaces\RelationshipInterface;
use Codememory\Components\Database\Schema\StatementComponents\ReferenceDefinition;

/**
 * Class SubscriptionEntity
 *
 * @package App\Orm\Entities
 */
#[ORM\Entity(tableName: 'subscriptions')]
#[ORM\Repository(repository: 'App\Orm\Repositories\SubscriptionRepository')]
class SubscriptionEntity
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
    #[ORM\Column(name: 'name', type: 'varchar', length: 32, nullable: false)]
    private mixed $name = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'description', type: 'varchar', length: 255, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private mixed $description = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'old_price', type: 'decimal', length: 10, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private mixed $old_price = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'price', type: 'decimal', length: 10, nullable: false)]
    private mixed $price = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'is_active', type: 'tinyint', length: 1, nullable: false)]
    #[ORM\DefaultValue(value: '0')]
    private mixed $is_active = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'created_at', type: 'datetime', length: null, nullable: false)]
    #[ORM\DefaultValue(value: 'CURRENT_TIMESTAMP')]
    private mixed $created_at = null;

    /**
     * @return mixed
     */
    public function getId(): mixed
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
     * @return mixed
     */
    public function getName(): mixed
    {

        return $this->name;

    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setDescription(mixed $value): static
    {

        $this->description = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getDescription(): mixed
    {

        return $this->description;

    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setOldPrice(mixed $value): static
    {

        $this->old_price = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getOldPrice(): mixed
    {

        return $this->old_price;

    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setPrice(mixed $value): static
    {

        $this->price = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getPrice(): mixed
    {

        return $this->price;

    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setIsActive(mixed $value): static
    {

        $this->is_active = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getIsActive(): mixed
    {

        return $this->is_active;

    }

    /**
     * @param mixed $value
     *
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

}