<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;
use Codememory\Components\Database\Orm\Interfaces\RelationshipInterface;

/**
 * Class SubscriptionOptionEntity
 *
 * @package App\Orm\Entities
 */
#[ORM\Entity(tableName: 'subscription_options')]
#[ORM\Repository(repository: 'App\Orm\Repositories\SubscriptionOptionRepository')]
class SubscriptionOptionEntity
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
    #[ORM\Column(name: 'option_name_id', type: 'int', length: null, nullable: false)]
    #[ORM\Reference(
        entity: SubscriptionOptionNameEntity::class,
        referencedColumnName: 'id',
        on: [RelationshipInterface::ON_DELETE],
        onOptions: [RelationshipInterface::DEFAULT_ON_OPTION]
    )]
    private mixed $option = null;

    /**
     * @var mixed
     */
    #[ORM\Column(name: 'subscription', type: 'int', length: null, nullable: false)]
    #[ORM\Reference(
        entity: SubscriptionEntity::class,
        referencedColumnName: 'id',
        on: [RelationshipInterface::ON_DELETE],
        onOptions: [RelationshipInterface::DEFAULT_ON_OPTION]
    )]
    private mixed $subscription = null;

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
    public function setOption(mixed $value): static
    {

        $this->option = $value;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getOption(): mixed
    {

        return $this->option;

    }

    /**
     * @param mixed $value
     *
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

}