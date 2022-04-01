<?php

namespace App\Service\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\DTO\UserProfileDTO;
use App\Entity\User;
use App\Entity\UserSession;
use App\Rest\ApiService;
use App\Service\JwtTokenGenerator;
use Codememory\Components\GEO\Geolocation;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class CreatorUserSessionService
 *
 * @package App\Service\Security\Auth
 *
 * @author  Codememory
 */
class CreatorUserSessionService extends ApiService
{

	/**
	 * @var string|null
	 */
	private ?string $accessToken = null;

	/**
	 * @var string|null
	 */
	private ?string $refreshToken = null;

	/**
	 * @param User             $authorizedUser
	 * @param AuthorizationDTO $authorizationDTO
	 *
	 * @return CreatorUserSessionService
	 */
	public function create(User $authorizedUser, AuthorizationDTO $authorizationDTO): CreatorUserSessionService
	{

		$jwtTokenGenerator = new JwtTokenGenerator();

		// Saving generated tokens
		$this->accessToken = $this->generateAccessToken($jwtTokenGenerator, $authorizedUser);
		$this->refreshToken = $this->generateRefreshToken($jwtTokenGenerator, $authorizedUser);

		$this->em->persist($this->collectEntity($authorizedUser, $authorizationDTO));
		$this->em->flush();

		return $this;

	}

	/**
	 * @param JwtTokenGenerator $generator
	 * @param User              $user
	 *
	 * @return string
	 */
	private function generateAccessToken(JwtTokenGenerator $generator, User $user): string
	{

		return $generator->encode(
			$this->getUserSchema($user),
			'JWT_ACCESS_PRIVATE_KEY',
			$_ENV['JWT_ACCESS_TTL']
		);

	}

	/**
	 * @param User $user
	 *
	 * @return array
	 */
	#[ArrayShape([
		'id'      => "int|null",
		'email'   => "null|string",
		'profile' => "array",
	])]
	private function getUserSchema(User $user): array
	{

		$userProfile = $user->getUserProfile();
		$userProfileSchema = [];

		if (null !== $userProfile) {
			$userProfileSchema = (new UserProfileDTO(managerRegistry: $this->managerRegistry))->toArray($userProfile);
		}

		return [
			'id'      => $user->getId(),
			'email'   => $user->getEmail(),
			'profile' => $userProfileSchema
		];

	}

	/**
	 * @param JwtTokenGenerator $generator
	 * @param User              $user
	 *
	 * @return string
	 */
	private function generateRefreshToken(JwtTokenGenerator $generator, User $user): string
	{

		return $generator->encode(
			$this->getUserSchema($user),
			'JWT_REFRESH_PRIVATE_KEY',
			$_ENV['JWT_REFRESH_TTL']
		);

	}

	/**
	 * @param User             $authorizedUser
	 * @param AuthorizationDTO $authorizationDTO
	 *
	 * @return UserSession
	 */
	private function collectEntity(User $authorizedUser, AuthorizationDTO $authorizationDTO): UserSession
	{

		$geo = new Geolocation();
		$userSessionEntity = new UserSession();

		$geo->setIp($authorizationDTO->clientIp);

		$location = $geo->getLocation();

		$userSessionEntity
			->setUser($authorizedUser)
			->setRefreshToken($this->refreshToken)
			->setIp($authorizationDTO->clientIp);

		// If there is information on this ip, fix it
		if ($geo->isSuccess()) {
			$userSessionEntity
				->setCountry($location->getCountry()->getName())
				->setCountryCode($location->getCountry()->getCode())
				->setRegion($location->getRegion()->getName())
				->setCity($location->getCity()->getName())
				->setLatitude($location->getCity()->getLatitude())
				->setLongitude($location->getCity()->getLongitude());
		}

		return $userSessionEntity;

	}

	/**
	 * @return string|null
	 */
	public function getAccessToken(): ?string
	{

		return $this->accessToken;

	}

	/**
	 * @return string|null
	 */
	public function getRefreshToken(): ?string
	{

		return $this->refreshToken;

	}

}