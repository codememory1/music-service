<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Repository\MusicEventRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class MediaLibraryMusicEvent
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MusicEventRepository::class)]
#[ORM\Table('media_library_music_events')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
	'mediaLibraryMusic',
	'mediaLibraryMusic@eventForMusicAdded',
	payload: ApiResponseTypeEnum::CHECK_EXIST
)]
class MediaLibraryMusicEvent implements EntityInterface
{

	use IdentifierTrait;
	use TimestampTrait;

	/**
	 * @var MediaLibraryMusic|null
	 */
	#[ORM\ManyToOne(targetEntity: MediaLibraryMusic::class, inversedBy: 'musicEvents')]
	#[ORM\JoinColumn(unique: true, nullable: false)]
	private ?MediaLibraryMusic $mediaLibraryMusic = null;

	/**
	 * @var string|null
	 */
	#[ORM\Column(type: Types::STRING, length: 100)]
	private ?string $name;

	/**
	 * @var array
	 */
	#[ORM\Column(type: Types::JSON)]
	private array $payload = [];

	/**
	 * @return int|null
	 */
	public function getId(): ?int
	{

		return $this->id;

	}

	/**
	 * @return MediaLibraryMusic|null
	 */
	public function getMediaLibraryMusic(): ?MediaLibraryMusic
	{

		return $this->mediaLibraryMusic;

	}

	/**
	 * @param MediaLibraryMusic|null $mediaLibraryMusic
	 *
	 * @return $this
	 */
	public function setMediaLibraryMusic(?MediaLibraryMusic $mediaLibraryMusic): self
	{

		$this->mediaLibraryMusic = $mediaLibraryMusic;

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
	 * @return array|null
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
