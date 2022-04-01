<?php

namespace App\Entity;

use App\Interfaces\EntityInterface;
use App\Repository\UserProfilePhotoRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserProfilePhoto
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: UserProfilePhotoRepository::class)]
#[ORM\Table('user_profile_photos')]
#[ORM\HasLifecycleCallbacks]
class UserProfilePhoto implements EntityInterface
{

	use IdentifierTrait;
	use TimestampTrait;

	/**
	 * @var UserProfile|null
	 */
	#[ORM\OneToOne(inversedBy: 'userProfilePhoto', targetEntity: UserProfile::class, cascade: ['persist', 'remove'])]
	#[ORM\JoinColumn(nullable: false)]
	private ?UserProfile $userProfile = null;

	/**
	 * @var string|null
	 */
	#[ORM\Column(type: Types::TEXT, options: [
		'comment' => 'Path to photography'
	])]
	private ?string $photo = null;

	/**
	 * @return UserProfile|null
	 */
	public function getUserProfile(): ?UserProfile
	{

		return $this->userProfile;

	}

	/**
	 * @param UserProfile $userProfile
	 *
	 * @return $this
	 */
	public function setUserProfile(UserProfile $userProfile): self
	{

		$this->userProfile = $userProfile;

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

}
