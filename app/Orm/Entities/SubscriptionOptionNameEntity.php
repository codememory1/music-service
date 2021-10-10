<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class SubscriptionOptionNameEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'subscription_option_names')]
#[ORM\Repository(repository: 'App\Orm\Repositories\SubscriptionOptionNameRepository')]
class SubscriptionOptionNameEntity
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
    #[ORM\Column(name: 'name', type: 'varchar', length: 50, nullable: false)]
    #[ORM\Unique]
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'title', type: 'varchar', length: 255, nullable: false)]
    private ?string $title = null;

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
    public function setName(string $value): static
    {

        $this->name = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {

        return $this->name;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setTitle(string $value): static
    {

        $this->title = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {

        return $this->title;

    }

}