<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Repository\AlbumTypeRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class AlbumType
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: AlbumTypeRepository::class)]
#[ORM\Table('album_types')]
#[UniqueEntity(
	'key',
	'albumType@keyExist',
	payload: ApiResponseTypeEnum::CHECK_EXIST
)]
#[ORM\HasLifecycleCallbacks]
class AlbumType implements EntityInterface
{

	use IdentifierTrait;
	use TimestampTrait;

	/**
	 * @var string|null
	 */
	#[ORM\Column('`key`', Types::STRING, length: 255, unique: true, options: [
		'comment' => 'Unique album type'
	])]
	private ?string $key = null;

	/**
	 * @var string|null
	 */
	#[ORM\Column(type: Types::STRING, length: 255, options: [
		'comment' => 'Type name translation key'
	])]
	private ?string $titleTranslationKey = null;

	/**
	 * @var Collection
	 */
	#[ORM\OneToMany(mappedBy: 'type', targetEntity: Album::class)]
	private Collection $albums;

	#[Pure]
	public function __construct()
	{

		$this->albums = new ArrayCollection();

	}

	/**
	 * @return string|null
	 */
	public function getKey(): ?string
	{

		return $this->key;

	}

	/**
	 * @param string $key
	 *
	 * @return $this
	 */
	public function setKey(string $key): self
	{

		$this->key = $key;

		return $this;

	}

	/**
	 * @return string|null
	 */
	public function getTitleTranslationKey(): ?string
	{

		return $this->titleTranslationKey;

	}

	/**
	 * @param string $titleTranslationKey
	 *
	 * @return $this
	 */
	public function setTitleTranslationKey(string $titleTranslationKey): self
	{

		$this->titleTranslationKey = $titleTranslationKey;

		return $this;

	}

	/**
	 * @return Collection
	 */
	public function getAlbums(): Collection
	{

		return $this->albums;

	}

	/**
	 * @param Album $album
	 *
	 * @return $this
	 */
	public function addAlbum(Album $album): self
	{

		if (!$this->albums->contains($album)) {
			$this->albums[] = $album;
			$album->setType($this);
		}

		return $this;

	}

	/**
	 * @param Album $album
	 *
	 * @return $this
	 */
	public function removeAlbum(Album $album): self
	{

		if ($this->albums->removeElement($album)) {
			// set the owning side to null (unless already changed)
			if ($album->getType() === $this) {
				$album->setType(null);
			}
		}

		return $this;

	}

}
