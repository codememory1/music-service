<?php

namespace App\Security\Registration;

use App\DTO\RegistrationDTO;
use App\Entity\User;
use App\Enum\ApiResponseTypeEnum;
use App\Enum\StatusEnum;
use App\Repository\UserRepository;
use App\Rest\Http\ApiResponseSchema;
use App\Rest\Http\Response;
use App\Rest\Translator;
use App\Security\AbstractSecurity;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class Registration
 *
 * @package App\Security\Registration
 *
 * @author  Codememory
 */
class Registration extends AbstractSecurity
{

	/**
	 * @var UserRepository
	 */
	private UserRepository $userRepository;

	/**
	 * @param ManagerRegistry $managerRegistry
	 * @param Translator      $translator
	 */
	public function __construct(ManagerRegistry $managerRegistry, Translator $translator)
	{

		parent::__construct($managerRegistry, $translator);

		/** @var UserRepository $userRepository */
		$userRepository = $this->em->getRepository(User::class);
		$this->userRepository = $userRepository;

	}

	/**
	 * @param RegistrationDTO $registrationDTO
	 *
	 * @return User|bool
	 */
	public function isReRegistration(RegistrationDTO $registrationDTO): User|bool
	{

		$finedUser = $this->userRepository->findOneBy([
			'email'  => $registrationDTO->email,
			'status' => StatusEnum::NOT_ACTIVE->value
		]);

		return null === $finedUser ? false : $finedUser;

	}

	/**
	 * @return Response
	 */
	public function successAuthResponse(): Response
	{

		$apiResponseSchema = new ApiResponseSchema();

		$apiResponseSchema->setMessage(
			ApiResponseTypeEnum::REGISTRATION,
			$this->translator->getTranslation('common@successRegister')
		);

		return new Response($apiResponseSchema, 'success', 200);

	}

}