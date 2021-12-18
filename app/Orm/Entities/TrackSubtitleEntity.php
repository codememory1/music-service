<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class TrackSubtitleEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'track_subtitles')]
#[ORM\Repository(repository: 'App\Orm\Repositories\TrackSubtitleRepository')]
class TrackSubtitleEntity
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
    #[ORM\Column(name: 'track_id', type: 'bigint unsigned', length: null, nullable: false)]
    private ?int $track_id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'subtitles', type: 'json', length: null, nullable: false)]
    #[ORM\DefaultValue(value: '[]')]
    private ?string $subtitles = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'created_at', type: 'datetime', length: null, nullable: false)]
    #[ORM\DefaultValue(value: 'CURRENT_TIMESTAMP')]
    private ?string $created_at = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'updated_at', type: 'datetime', length: null, nullable: false)]
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
     * @param int $value
     *
     * @return static
     */
    public function setTrackId(int $value): static
    {

        $this->track_id = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getTrackId(): ?int
    {

        return $this->track_id;

    }

    /**
     * @param array $value
     *
     * @return static
     */
    public function setSubtitles(array $value): static
    {

        $this->subtitles = json_encode($value);

        return $this;

    }

    /**
     * @return array
     */
    public function getSubtitles(): array
    {

        return json_decode($this->subtitles, true);

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