<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;
use Codememory\Components\Database\Orm\Interfaces\RelationshipInterface;
use Codememory\Components\Database\Schema\StatementComponents\ReferenceDefinition;

/**
 * Class AlbumArtistEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'album_artists')]
#[ORM\Repository(repository: 'App\Orm\Repositories\AlbumArtistRepository')]
class AlbumArtistEntity
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
    #[ORM\Column(name: 'user_id', type: 'bigint unsigned', length: null, nullable: false)]
    #[ORM\Reference(
        entity: UserEntity::class,
        referencedColumnName: 'id',
        on: [RelationshipInterface::ON_DELETE],
        onOptions: [ReferenceDefinition::RD_CASCADE]
    )]
    private ?int $user_id = null;

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

}