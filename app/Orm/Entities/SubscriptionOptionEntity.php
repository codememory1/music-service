<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;
use Codememory\Components\Database\Orm\Interfaces\RelationshipInterface;

/**
 * Class SubscriptionOptionEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'subscription_options')]
#[ORM\Repository(repository: 'App\Orm\Repositories\SubscriptionOptionRepository')]
class SubscriptionOptionEntity
{

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'id', type: 'int', length: null, nullable: false)]
    #[ORM\Identifier]
    private ?int $id = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'option_name_id', type: 'int', length: null, nullable: false)]
    #[ORM\Reference(
        entity: SubscriptionOptionNameEntity::class,
        referencedColumnName: 'id',
        on: [RelationshipInterface::ON_DELETE],
        onOptions: [RelationshipInterface::DEFAULT_ON_OPTION]
    )]
    private ?int $option_name_id = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'subscription', type: 'int', length: null, nullable: false)]
    #[ORM\Reference(
        entity: SubscriptionEntity::class,
        referencedColumnName: 'id',
        on: [RelationshipInterface::ON_DELETE],
        onOptions: [RelationshipInterface::DEFAULT_ON_OPTION]
    )]
    private ?int $subscription = null;

    /**
     * @var SubscriptionOptionNameEntity|null
     */
    #[ORM\Join(entity: SubscriptionOptionNameEntity::class, columns: ['option_name', 'option_title'], as: ['name', 'title'])]
    private ?SubscriptionOptionNameEntity $option_name = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * @param int $value
     *
     * @return static
     */
    public function setOption(int $value): static
    {

        $this->option_name_id = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getOption(): ?int
    {

        return $this->option_name_id;

    }

    /**
     * @param int $value
     *
     * @return static
     */
    public function setSubscription(int $value): static
    {

        $this->subscription = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getSubscription(): ?int
    {

        return $this->subscription;

    }

    /**
     * @return SubscriptionOptionNameEntity|null
     */
    public function getOptionName(): ?SubscriptionOptionNameEntity
    {

        return $this->option_name;

    }

}