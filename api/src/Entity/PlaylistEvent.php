<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Repository\PlaylistEventRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class PlaylistEvent.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: PlaylistEventRepository::class)]
#[ORM\Table('playlist_events')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
    'playlist',
    'playlist@eventForPlaylistAdded',
    payload: ApiResponseTypeEnum::CHECK_EXIST
)]
class PlaylistEvent implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    /**
     * @var null|Playlist
     */
    #[ORM\ManyToOne(targetEntity: Playlist::class, inversedBy: 'playlistEvents')]
    #[ORM\JoinColumn(unique: true, nullable: false)]
    private ?Playlist $playlist = null;

    /**
     * @var null|string
     */
    #[ORM\Column(type: Types::STRING, length: 100)]
    private ?string $name = null;

    /**
     * @var array
     */
    #[ORM\Column(type: Types::JSON)]
    private array $payload = [];

    /**
     * @return null|Playlist
     */
    public function getPlaylist(): ?Playlist
    {
        return $this->playlist;
    }

    /**
     * @param null|Playlist $playlist
     *
     * @return $this
     */
    public function setPlaylist(?Playlist $playlist): self
    {
        $this->playlist = $playlist;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|array
     */
    public function getPayload(): ?array
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     *
     * @return $this
     */
    public function setPayload(array $payload): self
    {
        $this->payload = $payload;

        return $this;
    }
}
