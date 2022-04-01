<?php

namespace App\Service\Security\PasswordReset;

use App\DTO\PasswordRecoveryRequestDTO;
use App\Entity\PasswordReset;
use App\Entity\User;
use App\Enum\ApiResponseTypeEnum;
use App\Enum\PasswordResetStatusEnum;
use App\Exception\UndefinedClassForDTOException;
use App\Repository\UserRepository;
use App\Rest\ApiService;
use App\Rest\Http\Response;
use App\Service\JwtTokenGenerator;
use Exception;

/**
 * Class RecoveryRequestService
 *
 * @package App\Service\PasswordReset
 *
 * @author  Codememory
 */
class RecoveryRequestService extends ApiService
{

	/**
	 * @param PasswordRecoveryRequestDTO $passwordRecoveryRequestDTO
	 *
	 * @return Response
	 * @throws UndefinedClassForDTOException
	 * @throws Exception
	 */
	public function send(PasswordRecoveryRequestDTO $passwordRecoveryRequestDTO): Response
	{

		/** @var UserRepository $userRepository */
		$userRepository = $this->em->getRepository(User::class);

		/** @var User $collectedEntity */
		$collectedEntity = $passwordRecoveryRequestDTO->getCollectedEntity();

		// POST input validation
		if (false !== $resultInputValidation = $this->inputValidation($collectedEntity)) {
			return $resultInputValidation;
		}

		// Send a message about a successful request without further action
		$finedUser = $userRepository->findBy(['email' => $collectedEntity->getEmail()]);

		if (null !== $finedUser) {
			return $this->successRecoveryRequest();
		}

		return $this->create($finedUser);

	}

	/**
	 * @return Response
	 */
	private function successRecoveryRequest(): Response
	{

		$this->apiResponseSchema->setMessage(
			ApiResponseTypeEnum::CREATE,
			$this->getTranslation('recoveryRequest@successCreate')
		);

		return new Response($this->apiResponseSchema, 'success', 200);

	}

	/**
	 * @param User $user
	 *
	 * @return Response
	 * @throws Exception
	 */
	private function create(User $user): Response
	{

		$passwordResetEntity = new PasswordReset();

		$passwordResetEntity
			->setUser($user)
			->setToken($this->generateToken($user))
			->setStatus(PasswordResetStatusEnum::WAITING_RESET);

		return $this->manager->push($passwordResetEntity, 'recoveryRequest@successCreate');

	}

	/**
	 * @param User $user
	 *
	 * @return string
	 */
	private function generateToken(User $user): string
	{

		$jwtTokenGenerator = new JwtTokenGenerator();

		return $jwtTokenGenerator->encode(
			['id' => $user->getId()],
			'JWT_PASSWORD_RESET_PRIVATE_KEY',
			$_ENV['JWT_PASSWORD_RESET_TTL']
		);

	}

}