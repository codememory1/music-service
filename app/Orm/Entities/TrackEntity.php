<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;
use Codememory\Components\Database\Orm\Interfaces\RelationshipInterface;
use Codememory\Components\Database\Schema\StatementComponents\ReferenceDefinition;

/**
 * Class TrackEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'tracks')]
#[ORM\Repository(repository: 'App\Orm\Repositories\TrackRepository')]
class TrackEntity
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
    #[ORM\Column(name: 'hash', type: 'varchar', length: 255, nullable: false)]
    private ?string $hash = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'name', type: 'varchar', length: 255, nullable: false)]
    private ?string $name = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'category_id', type: 'bigint unsigned', length: null, nullable: false)]
    #[ORM\Reference(
        entity: TrackCategoryEntity::class,
        referencedColumnName: 'id',
        on: [RelationshipInterface::ON_DELETE],
        onOptions: [ReferenceDefinition::RD_CASCADE]
    )]
    private ?int $category_id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'image', type: 'varchar', length: 255, nullable: false)]
    private ?string $image = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'text', type: 'text', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private ?string $text = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'album_id', type: 'bigint unsigned', length: null, nullable: false)]
    #[ORM\Reference(
        entity: AlbumEntity::class,
        referencedColumnName: 'id',
        on: [RelationshipInterface::ON_DELETE],
        onOptions: [ReferenceDefinition::RD_CASCADE]
    )]
    private ?int $album_id = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'duration_time', type: 'bigint unsigned', length: null, nullable: false)]
    private ?int $duration_time = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'foul_language', type: 'tinyint', length: 1, nullable: false)]
    #[ORM\DefaultValue(value: '0')]
    private ?int $foul_language = null;

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
    public function setHash(string $value): static
    {

        $this->hash = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getHash(): ?string
    {

        return $this->hash;

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
    public function setCategoryId(string $value): static
    {

        $this->category_id = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getCategoryId(): ?int
    {

        return $this->category_id;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setImage(string $value): static
    {

        $this->image = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {

        return $this->image;

    }

    /**
     * @param string|null $value
     *
     * @return static
     */
    public function setText(?string $value): static
    {

        $this->text = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {

        return $this->text;

    }

    /**
     * @param int $value
     *
     * @return static
     */
    public function setAlbumId(int $value): static
    {

        $this->album_id = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getAlbumId(): ?int
    {

        return $this->album_id;

    }

    /**
     * @param int $value
     *
     * @return static
     */
    public function setDurationTime(int $value): static
    {

        $this->duration_time = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getDurationTime(): ?int
    {

        return $this->duration_time;

    }

    /**
     * @param bool $value
     *
     * @return static
     */
    public function setFoulLanguage(bool $value): static
    {

        $this->foul_language = (int) $value;

        return $this;

    }

    /**
     * @return bool
     */
    public function getFoulLanguage(): bool
    {

        return (bool) $this->foul_language;

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