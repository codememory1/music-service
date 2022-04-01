<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Repository\MediaLibraryMusicRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class MediaLibraryMusic
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MediaLibraryMusicRepository::class)]
#[ORM\Table('media_library_musics')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
	['music', 'mediaLibrary'],
	'mediaLibrary@musicAdded',
	payload: ApiResponseTypeEnum::CHECK_EXIST
)]
class MediaLibraryMusic implements EntityInterface
{

	use IdentifierTrait;
	use TimestampTrait;

	/**
	 * @var MediaLibrary|null
	 */
	#[ORM\ManyToOne(targetEntity: MediaLibrary::class, inversedBy: 'mediaLibraryMusic')]
	private ?MediaLibrary $mediaLibrary = null;

	/**
	 * @var Music|null
	 */
	#[ORM\ManyToOne(targetEntity: Music::class)]
	#[ORM\JoinColumn(nullable: false)]
	private ?Music $music = null;

	/**
	 * @var bool
	 */
	#[ORM\Column(type: Types::BOOLEAN)]
	private bool $downloadedToDevice = false;

	/**
	 * @var bool
	 */
	#[ORM\Column(type: Types::BOOLEAN)]
	private bool $downloadedToCache = false;

	/**
	 * @var int|null
	 */
	#[ORM\Column(type: Types::INTEGER)]
	private ?int $status = null;

	/**
	 * @var Collection
	 */
	#[ORM\OneToMany(mappedBy: 'mediaLibraryMusic', targetEntity: MediaLibraryMusicEvent::class, cascade: ['persist', 'remove'])]
	private Collection $mediaLibraryMusicEvents;

	#[Pure]
	public function __construct()
	{

		$this->mediaLibraryMusicEvents = new ArrayCollection();

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
	 * @return Music|null
	 */
	public function getMusic(): ?Music
	{

		return $this->music;

	}

	/**
	 * @param Music $music
	 *
	 * @return $this
	 */
	public function setMusic(Music $music): self
	{

		$this->music = $music;

		return $this;

	}

	/**
	 * @return bool|null
	 */
	public function getDownloadedToDevice(): ?bool
	{

		return $this->downloadedToDevice;

	}

	/**
	 * @param bool $downloadedToDevice
	 *
	 * @return $this
	 */
	public function setDownloadedToDevice(bool $downloadedToDevice): self
	{

		$this->downloadedToDevice = $downloadedToDevice;

		return $this;

	}

	/**
	 * @return bool|null
	 */
	public function getDownloadedToCache(): ?bool
	{

		return $this->downloadedToCache;

	}

	/**
	 * @param bool $downloadedToCache
	 *
	 * @return $this
	 */
	public function setDownloadedToCache(bool $downloadedToCache): self
	{

		$this->downloadedToCache = $downloadedToCache;

		return $this;

	}

	/**
	 * @return int|null
	 */
	public function getStatus(): ?int
	{

		return $this->status;

	}

	/**
	 * @param int $status
	 *
	 * @return $this
	 */
	public function setStatus(int $status): self
	{

		$this->status = $status;

		return $this;

	}

	/**
	 * @return Collection
	 */
	public function getEvents(): Collection
	{

		return $this->mediaLibraryMusicEvents;

	}

	/**
	 * @param MediaLibraryMusicEvent $mediaLibraryMusicEvent
	 *
	 * @return $this
	 */
	public function addEvent(MediaLibraryMusicEvent $mediaLibraryMusicEvent): self
	{

		if (!$this->mediaLibraryMusicEvents->contains($mediaLibraryMusicEvent)) {
			$this->mediaLibraryMusicEvents[] = $mediaLibraryMusicEvent;
			$mediaLibraryMusicEvent->setMediaLibraryMusic($this);
		}

		return $this;

	}

	/**
	 * @param MediaLibraryMusicEvent $mediaLibraryMusicEvent
	 *
	 * @return $this
	 */
	public function removeEvent(MediaLibraryMusicEvent $mediaLibraryMusicEvent): self
	{

		if ($this->mediaLibraryMusicEvents->removeElement($mediaLibraryMusicEvent)) {
			// set the owning side to null (unless already changed)
			if ($mediaLibraryMusicEvent->getMediaLibraryMusic() === $this) {
				$mediaLibraryMusicEvent->setMediaLibraryMusic(null);
			}
		}

		return $this;

	}

}
