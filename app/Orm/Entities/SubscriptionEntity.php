<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class SubscriptionEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'subscriptions')]
#[ORM\Repository(repository: 'App\Orm\Repositories\SubscriptionRepository')]
class SubscriptionEntity
{

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'id', type: 'bigint unsigned', length: null, nullable: false)]
    #[ORM\Identifier]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'name', type: 'varchar', length: 32, nullable: false)]
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'description', type: 'varchar', length: 255, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private ?string $description = null;

    /**
     * @var int|float|null
     */
    #[ORM\Column(name: 'old_price', type: 'decimal', length: 10, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private int|float|null $old_price = null;

    /**
     * @var int|float|null
     */
    #[ORM\Column(name: 'price', type: 'decimal', length: 10, nullable: false)]
    private int|float|null $price = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'is_active', type: 'tinyint', length: 1, nullable: false)]
    #[ORM\DefaultValue(value: '0')]
    private ?int $is_active = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'created_at', type: 'datetime', length: null, nullable: false)]
    #[ORM\DefaultValue(value: 'CURRENT_TIMESTAMP')]
    private ?string $created_at = null;

    /**
     * @var SubscriptionOptionEntity[]
     */
    private array $options = [];

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
    public function setDescription(string $value): static
    {

        $this->description = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {

        return $this->description;

    }

    /**
     * @param int|float $value
     *
     * @return static
     */
    public function setOldPrice(int|float $value): static
    {

        $this->old_price = $value;

        return $this;

    }

    /**
     * @return int|float|null
     */
    public function getOldPrice(): int|null|float
    {

        return $this->old_price;

    }

    /**
     * @param int|float $value
     *
     * @return static
     */
    public function setPrice(int|float $value): static
    {

        $this->price = $value;

        return $this;

    }

    /**
     * @return int|float|null
     */
    public function getPrice(): int|null|float
    {

        return $this->price;

    }

    /**
     * @param bool $value
     *
     * @return static
     */
    public function setIsActive(bool $value): static
    {

        $this->is_active = $value ? 1 : 0;

        return $this;

    }

    /**
     * @return bool
     */
    public function getIsActive(): bool
    {

        return $this->is_active > 1;

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
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {

        return $this->created_at;

    }

    /**
     * @param array $options
     *
     * @return SubscriptionEntity
     */
    public function setOptions(array $options): static
    {

        $this->options = $options;

        return $this;

    }

    /**
     * @return SubscriptionOptionEntity[]
     */
    public function getOptions(): array
    {

        return $this->options;

    }

}