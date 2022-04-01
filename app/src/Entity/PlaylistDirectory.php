<?php

namespace App\Entity;

use App\Interfaces\EntityInterface;
use App\Repository\PlaylistDirectoryRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PlaylistDirectory
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: PlaylistDirectoryRepository::class)]
#[ORM\Table('playlist_directories')]
#[ORM\HasLifecycleCallbacks]
class PlaylistDirectory implements EntityInterface
{

	use IdentifierTrait;
	use TimestampTrait;

	/**
	 * @var string|null
	 */
	#[ORM\Column(type: Types::STRING, length: 255)]
	private ?string $name = null;

	/**
	 * @var Playlist|null
	 */
	#[ORM\ManyToOne(targetEntity: Playlist::class, inversedBy: 'playlistDirectories')]
	#[ORM\JoinColumn(nullable: false)]
	private ?Playlist $playlist;

	/**
	 * @return string|null
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
	 * @return Playlist|null
	 */
	public function getPlaylist(): ?Playlist
	{

		return $this->playlist;

	}

	/**
	 * @param Playlist|null $playlist
	 *
	 * @return $this
	 */
	public function setPlaylist(?Playlist $playlist): self
	{

		$this->playlist = $playlist;

		return $this;

	}

}
