<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class PlaylistEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'playlists')]
#[ORM\Repository(repository: 'App\Orm\Repositories\PlaylistRepository')]
class PlaylistEntity
{

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'id', type: 'bigint unsigned', length: null, nullable: false)]
    #[ORM\Identifier]
    private ?int $id = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'user_id', type: 'bigint unsigned', length: null, nullable: false)]
    private ?int $user_id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'name', type: 'varchar', length: 100, nullable: false)]
    private ?string $name = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'reserved', type: 'tinyint', length: 1, nullable: false)]
    #[ORM\DefaultValue(value: '0')]
    private ?int $reserved = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'temporary', type: 'datetime', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private ?string $temporary = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'created_at', type: 'datetime', length: null, nullable: false)]
    #[ORM\DefaultValue(value: 'CURRENT_TIMESTAMP')]
    private ?string $created_at = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'updated_at', type: 'datetime', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private ?string $updated_at = null;

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
    public function setUserId(int $value): static
    {

        $this->user_id = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {

        return $this->user_id;

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
     * @param bool $value
     *
     * @return static
     */
    public function setReserved(bool $value): static
    {

        $this->reserved = $value ? 1 : 0;

        return $this;

    }

    /**
     * @return bool
     */
    public function getReserved(): bool
    {

        return $this->reserved > 1;

    }

    /**
     * @param string|null $value
     *
     * @return static
     */
    public function setTemporary(?string $value): static
    {

        $this->temporary = empty($value) ? null : $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getTemporary(): ?string
    {

        return $this->temporary;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setCreatedAt(string $value): static
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
     * @param string $value
     *
     * @return static
     */
    public function setUpdatedAt(string $value): static
    {

        $this->updated_at = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {

        return $this->updated_at;

    }

}