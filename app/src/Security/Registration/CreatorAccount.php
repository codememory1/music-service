<?php

namespace App\Security\Registration;

use App\DTO\RegistrationDTO;
use App\Entity\User;
use App\Security\AbstractSecurity;

/**
 * Class CreatorAccount
 *
 * @package App\Security\Registration
 *
 * @author  Codememory
 */
class CreatorAccount extends AbstractSecurity
{

	/**
	 * @param RegistrationDTO $registrationDTO
	 *
	 * @return User
	 */
	public function create(RegistrationDTO $registrationDTO): User
	{

		/** @var User $userEntity */
		$userEntity = $registrationDTO->getCollectedEntity();

		$this->em->persist($userEntity);
		$this->em->flush();

		return $userEntity;

	}

	/**
	 * @param RegistrationDTO $registrationDTO
	 * @param User            $user
	 *
	 * @return User
	 */
	public function reCreate(RegistrationDTO $registrationDTO, User $user): User
	{

		$passwordHashing = new PasswordHashing();

		$user->setPassword($passwordHashing->encode($registrationDTO));

		$this->em->flush();

		return $user;

	}

}