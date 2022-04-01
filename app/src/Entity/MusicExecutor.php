<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Repository\MusicExecutorRepository;
use App\Trait\Entity\IdentifierTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class MusicExecutor
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MusicExecutorRepository::class)]
#[ORM\Table('music_executors')]
#[UniqueEntity(
	['music', 'artist'],
	'musicExecutor@execurotForMusicExist',
	payload: ApiResponseTypeEnum::CHECK_EXIST
)]
class MusicExecutor implements EntityInterface
{

	use IdentifierTrait;

	/**
	 * @var Music|null
	 */
	#[ORM\ManyToOne(targetEntity: Music::class, inversedBy: 'musicExecutors')]
	#[ORM\JoinColumn(nullable: false)]
	private ?Music $music = null;

	/**
	 * @var User|null
	 */
	#[ORM\OneToOne(targetEntity: User::class, cascade: ['persist', 'remove'])]
	#[ORM\JoinColumn(nullable: false)]
	private ?User $artist = null;

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
	public function getArtist(): ?User
	{

		return $this->artist;

	}

	/**
	 * @param User|null $artist
	 *
	 * @return $this
	 */
	public function setArtist(?User $artist): self
	{

		$this->artist = $artist;

		return $this;

	}

}
