<?php

namespace App\Security\Session;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Entity\UserSession;
use App\Security\AbstractSecurity;
use App\Service\JwtTokenGenerator;
use Codememory\Components\GEO\Geolocation;
use Jenssegers\Agent\Agent;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class CreatorSession
 *
 * @package App\Security\Session
 *
 * @author  Codememory
 */
class CreatorSession extends AbstractSecurity
{

	/**
	 * @param User             $identifiedUser
	 * @param AuthorizationDTO $authorizationDTO
	 *
	 * @return array
	 */
	#[ArrayShape([
		'access_token'  => "string",
		'refresh_token' => "string"
	])]
	public function create(User $identifiedUser, AuthorizationDTO $authorizationDTO): array
	{

		$geo = new Geolocation();
		$agent = new Agent();
		$userSessionEntity = new UserSession();
		$generatedTokens = $this->generateTokens($identifiedUser);

		$geo->setIp($authorizationDTO->clientIp);

		$userSessionEntity
			->setUser($identifiedUser)
			->setBrowser($agent->browser())
			->setIp($authorizationDTO->clientIp)
			->setDeviceModel($agent->device())
			->setOperatingSystem($agent->platform())
			->setRefreshToken($generatedTokens['refresh_token']);

		// Set info by IP
		if ($geo->isSuccess()) {
			$location = $geo->getLocation();
			$country = $location->getCountry();
			$city = $location->getCity();
			$region = $location->getRegion();

			$userSessionEntity
				->setCountry($country->getName())
				->setCountryCode($country->getCode())
				->setLatitude($country->getLatitude())
				->setLongitude($country->getLongitude())
				->setCity($city->getName())
				->setRegion($region->getName());
		}

		$this->em->persist($userSessionEntity);
		$this->em->flush();

		return $generatedTokens;

	}

	/**
	 * @param User $user
	 *
	 * @return array
	 */
	#[ArrayShape([
		'access_token'  => "string",
		'refresh_token' => "string"
	])]
	private function generateTokens(User $user): array
	{

		$jwtTokenGenerator = new JwtTokenGenerator();

		return [
			'access_token'  => $this->generateAccessToken($jwtTokenGenerator, $user),
			'refresh_token' => $this->generateRefreshToken($jwtTokenGenerator, $user)
		];

	}

	/**
	 * @param JwtTokenGenerator $jwtTokenGenerator
	 * @param User              $user
	 *
	 * @return string
	 */
	private function generateAccessToken(JwtTokenGenerator $jwtTokenGenerator, User $user): string
	{

		return $jwtTokenGenerator->encode(
			$this->tokenSchema($user),
			'JWT_ACCESS_PRIVATE_KEY',
			'JWT_ACCESS_TTL'
		);

	}

	/**
	 * @param User $identifiedUser
	 *
	 * @return array
	 */
	#[Pure]
	#[ArrayShape([
		'id'    => "int|null",
		'email' => "null|string"
	])]
	private function tokenSchema(User $identifiedUser): array
	{

		return [
			'id'    => $identifiedUser->getId(),
			'email' => $identifiedUser->getEmail()
		];

	}

	/**
	 * @param JwtTokenGenerator $jwtTokenGenerator
	 * @param User              $user
	 *
	 * @return string
	 */
	private function generateRefreshToken(JwtTokenGenerator $jwtTokenGenerator, User $user): string
	{

		return $jwtTokenGenerator->encode(
			$this->tokenSchema($user),
			'JWT_REFRESH_PRIVATE_KEY',
			'JWT_REFRESH_TTL'
		);

	}

}