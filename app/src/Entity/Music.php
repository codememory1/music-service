<?php

namespace App\Entity;

use App\Interfaces\EntityInterface;
use App\Repository\MusicRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * Class Music
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MusicRepository::class)]
#[ORM\Table('musics')]
#[ORM\HasLifecycleCallbacks]
class Music implements EntityInterface
{

	use IdentifierTrait;
	use TimestampTrait;

	/**
	 * @var string|null
	 */
	#[ORM\Column(type: Types::STRING, length: 50)]
	private ?string $type = null;

	/**
	 * @var string|null
	 */
	#[ORM\Column(type: Types::STRING, length: 255)]
	private ?string $name = null;

	/**
	 * @var Album|null
	 */
	#[ORM\ManyToOne(targetEntity: Album::class, inversedBy: 'musics')]
	#[ORM\JoinColumn(nullable: false)]
	private ?Album $album = null;

	/**
	 * @var string|null
	 */
	#[ORM\Column(type: Types::TEXT)]
	private ?string $photo = null;

	/**
	 * @var string|null
	 */
	#[ORM\Column(type: Types::TEXT, nullable: true)]
	private ?string $fullText = null;

	/**
	 * @var array
	 */
	#[ORM\Column(type: Types::ARRAY, nullable: true)]
	private array $subtitles = [];

	/**
	 * @var bool
	 */
	#[ORM\Column(type: Types::BOOLEAN)]
	private bool $foulLanguage = false;

	/**
	 * @var bool
	 */
	#[ORM\Column(type: Types::BOOLEAN)]
	private bool $published = false;

	/**
	 * @var Collection
	 */
	#[ORM\OneToMany(mappedBy: 'music', targetEntity: MusicRating::class, cascade: ['persist', 'remove'])]
	private Collection $musicRatings;

	/**
	 * @var Collection
	 */
	#[ORM\OneToMany(mappedBy: 'music', targetEntity: MusicExecutor::class, cascade: ['persist', 'remove'])]
	private Collection $musicExecutors;

	#[Pure]
	public function __construct()
	{

		$this->musicRatings = new ArrayCollection();
		$this->musicExecutors = new ArrayCollection();

	}

	/**
	 * @return string|null
	 */
	public function getType(): ?string
	{

		return $this->type;

	}

	/**
	 * @param string $type
	 *
	 * @return $this
	 */
	public function setType(string $type): self
	{

		$this->type = $type;

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
	 * @return Album|null
	 */
	public function getAlbum(): ?Album
	{

		return $this->album;

	}

	/**
	 * @param Album|null $album
	 *
	 * @return $this
	 */
	public function setAlbum(?Album $album): self
	{

		$this->album = $album;

		return $this;

	}

	/**
	 * @return string|null
	 */
	public function getPhoto(): ?string
	{

		return $this->photo;

	}

	/**
	 * @param string $photo
	 *
	 * @return $this
	 */
	public function setPhoto(string $photo): self
	{

		$this->photo = $photo;

		return $this;

	}

	/**
	 * @return string|null
	 */
	public function getFullText(): ?string
	{

		return $this->fullText;

	}

	/**
	 * @param string|null $fullText
	 *
	 * @return $this
	 */
	public function setFullText(?string $fullText): self
	{

		$this->fullText = $fullText;

		return $this;

	}

	/**
	 * @return array
	 */
	public function getSubtitles(): array
	{

		return $this->subtitles;

	}

	/**
	 * @param array $subtitles
	 *
	 * @return $this
	 */
	public function setSubtitles(array $subtitles): self
	{

		$this->subtitles = $subtitles;

		return $this;

	}

	/**
	 * @return bool
	 */
	public function getFoulLanguage(): bool
	{

		return $this->foulLanguage;

	}

	/**
	 * @param bool $foulLanguage
	 *
	 * @return $this
	 */
	public function setFoulLanguage(bool $foulLanguage): self
	{

		$this->foulLanguage = $foulLanguage;

		return $this;

	}

	/**
	 * @return bool|null
	 */
	public function getPublished(): ?bool
	{

		return $this->published;

	}

	/**
	 * @param bool $published
	 *
	 * @return $this
	 */
	public function setPublished(bool $published): self
	{

		$this->published = $published;

		return $this;

	}

	/**
	 * @return Collection
	 */
	public function getMusicRatings(): Collection
	{

		return $this->musicRatings;
	}

	/**
	 * @param MusicRating $musicRating
	 *
	 * @return $this
	 */
	public function addMusicRating(MusicRating $musicRating): self
	{

		if (!$this->musicRatings->contains($musicRating)) {
			$this->musicRatings[] = $musicRating;
			$musicRating->setMusic($this);
		}

		return $this;

	}

	/**
	 * @param MusicRating $musicRating
	 *
	 * @return $this
	 */
	public function removeMusicRating(MusicRating $musicRating): self
	{

		if ($this->musicRatings->removeElement($musicRating)) {
			// set the owning side to null (unless already changed)
			if ($musicRating->getMusic() === $this) {
				$musicRating->setMusic(null);
			}
		}

		return $this;

	}

	/**
	 * @return Collection
	 */
	public function getExecutors(): Collection
	{

		return $this->musicExecutors;
	}

	/**
	 * @param MusicExecutor $musicExecutor
	 *
	 * @return $this
	 */
	public function addExecutor(MusicExecutor $musicExecutor): self
	{

		if (!$this->musicExecutors->contains($musicExecutor)) {
			$this->musicExecutors[] = $musicExecutor;
			$musicExecutor->setMusic($this);
		}

		return $this;

	}

	/**
	 * @param MusicExecutor $musicExecutor
	 *
	 * @return $this
	 */
	public function removeExecutor(MusicExecutor $musicExecutor): self
	{

		if ($this->musicExecutors->removeElement($musicExecutor)) {
			// set the owning side to null (unless already changed)
			if ($musicExecutor->getMusic() === $this) {
				$musicExecutor->setMusic(null);
			}
		}

		return $this;
	}

}
