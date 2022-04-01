<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Repository\MediaLibraryEventRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class MediaLibraryEvent
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MediaLibraryEventRepository::class)]
#[ORM\Table('media_library_events')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
	'mediaLibrary',
	'mediaLibrary@eventForMediaLibraryAdded',
	payload: ApiResponseTypeEnum::CHECK_EXIST
)]
class MediaLibraryEvent implements EntityInterface
{

	use IdentifierTrait;
	use TimestampTrait;

	/**
	 * @var MediaLibrary|null
	 */
	#[ORM\ManyToOne(targetEntity: MediaLibrary::class, inversedBy: 'mediaLibraryEvents')]
	#[ORM\JoinColumn(unique: true, nullable: false)]
	private ?MediaLibrary $mediaLibrary = null;

	/**
	 * @var string|null
	 */
	#[ORM\Column(type: Types::STRING, length: 100)]
	private ?string $name = null;

	/**
	 * @var array
	 */
	#[ORM\Column(type: Types::JSON)]
	private array $payload = [];

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
