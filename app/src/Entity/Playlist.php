<?php

namespace App\Entity;

use App\Interfaces\EntityInterface;
use App\Repository\PlaylistRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * Class Playlist
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
#[ORM\Table('playlists')]
#[ORM\HasLifecycleCallbacks]
class Playlist implements EntityInterface
{

	use IdentifierTrait;
	use TimestampTrait;

	/**
	 * @var string|null
	 */
	#[ORM\Column(type: Types::STRING, length: 255)]
	private ?string $name = null;

	/**
	 * @var MediaLibrary|null
	 */
	#[ORM\ManyToOne(targetEntity: MediaLibrary::class, inversedBy: 'playlists')]
	#[ORM\JoinColumn(nullable: false)]
	private ?MediaLibrary $mediaLibrary = null;

	/**
	 * @var Collection
	 */
	#[ORM\OneToMany(mappedBy: 'playlist', targetEntity: PlaylistDirectory::class, cascade: ['persist', 'remove'])]
	private Collection $playlistDirectories;

	/**
	 * @var Collection
	 */
	#[ORM\OneToMany(mappedBy: 'playlist', targetEntity: PlaylistEvent::class, cascade: ['persist', 'remove'])]
	private Collection $playlistEvents;

	#[Pure]
	public function __construct()
	{

		$this->playlistDirectories = new ArrayCollection();
		$this->playlistEvents = new ArrayCollection();
	}

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
	 * @return MediaLibrary|null
	 */
	public function getMediaLibrary(): ?MediaLibrary
	{

		return $this->mediaLibrary;

	}

	/**
	 * @param MediaLibrary|null $mediaLibrary
	 *
	 * @return $this
	 */
	public function setMediaLibrary(?MediaLibrary $mediaLibrary): self
	{

		$this->mediaLibrary = $mediaLibrary;

		return $this;

	}

	/**
	 * @return Collection
	 */
	public function getDirectories(): Collection
	{

		return $this->playlistDirectories;

	}

	/**
	 * @param PlaylistDirectory $playlistDirectory
	 *
	 * @return $this
	 */
	public function addDirectory(PlaylistDirectory $playlistDirectory): self
	{

		if (!$this->playlistDirectories->contains($playlistDirectory)) {
			$this->playlistDirectories[] = $playlistDirectory;
			$playlistDirectory->setPlaylist($this);
		}

		return $this;

	}

	/**
	 * @param PlaylistDirectory $playlistDirectory
	 *
	 * @return $this
	 */
	public function removeDirectory(PlaylistDirectory $playlistDirectory): self
	{

		if ($this->playlistDirectories->removeElement($playlistDirectory)) {
			// set the owning side to null (unless already changed)
			if ($playlistDirectory->getPlaylist() === $this) {
				$playlistDirectory->setPlaylist(null);
			}
		}

		return $this;

	}

	/**
	 * @return Collection
	 */
	public function getEvents(): Collection
	{

		return $this->playlistEvents;

	}

	/**
	 * @param PlaylistEvent $playlistEvent
	 *
	 * @return $this
	 */
	public function addEvent(PlaylistEvent $playlistEvent): self
	{

		if (!$this->playlistEvents->contains($playlistEvent)) {
			$this->playlistEvents[] = $playlistEvent;
			$playlistEvent->setPlaylist($this);
		}

		return $this;

	}

	/**
	 * @param PlaylistEvent $playlistEvent
	 *
	 * @return $this
	 */
	public function removeEvent(PlaylistEvent $playlistEvent): self
	{

		if ($this->playlistEvents->removeElement($playlistEvent)) {
			// set the owning side to null (unless already changed)
			if ($playlistEvent->getPlaylist() === $this) {
				$playlistEvent->setPlaylist(null);
			}
		}

		return $this;

	}

}
