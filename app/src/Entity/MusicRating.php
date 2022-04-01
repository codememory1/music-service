<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Repository\MusicRatingRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class MusicRating
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MusicRatingRepository::class)]
#[ORM\Table('music_ratings')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
	['music', 'user'],
	'musicRating@ratingAdded',
	payload: ApiResponseTypeEnum::CHECK_EXIST
)]
class MusicRating implements EntityInterface
{

	use IdentifierTrait;
	use TimestampTrait;

	/**
	 * @var string|null
	 */
	#[ORM\Column(type: Types::STRING, length: 50)]
	private ?string $type = null;

	/**
	 * @var Music|null
	 */
	#[ORM\ManyToOne(targetEntity: Music::class, inversedBy: 'musicRatings')]
	#[ORM\JoinColumn(nullable: false)]
	private ?Music $music = null;

	/**
	 * @var User|null
	 */
	#[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'musicRatings')]
	#[ORM\JoinColumn(nullable: false)]
	private ?User $user = null;

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
	 * @return Music|null
	 */
	public function getMusic(): ?Music
	{

		return $this->music;

	}

	/**
	 * @param Music|null $music
	 *
	 * @return $this
	 */
	public function setMusic(?Music $music): self
	{

		$this->music = $music;

		return $this;

	}

	/**
	 * @return User|null
	 */
	public function getUser(): ?User
	{

		return $this->user;

	}

	/**
	 * @param User|null $user
	 *
	 * @return $this
	 */
	public function setUser(?User $user): self
	{

		$this->user = $user;

		return $this;

	}

}
