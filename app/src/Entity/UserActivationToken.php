<?php

namespace App\Entity;

use App\Interfaces\EntityInterface;
use App\Repository\UserActivationTokenRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserActivationToken
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: UserActivationTokenRepository::class)]
#[ORM\Table('user_activation_tokens')]
#[ORM\HasLifecycleCallbacks]
class UserActivationToken implements EntityInterface
{

	use IdentifierTrait;
	use TimestampTrait;

	/**
	 * @var User|null
	 */
	#[ORM\OneToOne(inversedBy: 'userActivationToken', targetEntity: User::class, cascade: ['persist'])]
	#[ORM\JoinColumn(nullable: false)]
	private ?User $user = null;

	/**
	 * @var string|null
	 */
	#[ORM\Column(type: Types::TEXT, options: [
		'comment' => 'Account activation token'
	])]
	private ?string $token = null;

	/**
	 * @return User|null
	 */
	public function getUser(): ?User
	{

		return $this->user;

	}

	/**
	 * @param User $user
	 *
	 * @return $this
	 */
	public function setUser(User $user): self
	{

		$this->user = $user;

		return $this;

	}

	/**
	 * @return string|null
	 */
	public function getToken(): ?string
	{

		return $this->token;

	}

	/**
	 * @param string $token
	 *
	 * @return $this
	 */
	public function setToken(string $token): self
	{

		$this->token = $token;

		return $this;

	}

}
