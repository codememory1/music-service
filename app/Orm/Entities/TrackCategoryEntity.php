<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class TrackCategoryEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'track_categories')]
#[ORM\Repository(repository: 'App\Orm\Repositories\TrackCategoryRepository')]
class TrackCategoryEntity
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
    #[ORM\Column(name: 'translation_key', type: 'varchar', length: 64, nullable: false)]
    private ?string $translation_key = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'created_at', type: 'datetime', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'CURRENT_TIMESTAMP')]
    private ?string $created_at = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'updated_at', type: 'datetime', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'CURRENT_TIMESTAMP')]
    private ?string $updated_at = null;

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
    public function setTranslationKey(string $value): static
    {

        $this->translation_key = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getTranslationKey(): ?string
    {

        return $this->translation_key;

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