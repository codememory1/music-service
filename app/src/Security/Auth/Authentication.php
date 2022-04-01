<?php

namespace App\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Enum\ApiResponseTypeEnum;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use App\Service\PasswordHashingService;

/**
 * Class Authentication
 *
 * @package App\Security\Auth
 *
 * @author  Codememory
 */
class Authentication extends AbstractSecurity
{

	/**
	 * @param User             $identifiedUser
	 * @param AuthorizationDTO $authorizationDTO
	 *
	 * @return Response|User
	 */
	public function authenticate(User $identifiedUser, AuthorizationDTO $authorizationDTO): Response|User
	{

		// Check compare password with identified user
		if (!$this->comparePassword($identifiedUser, $authorizationDTO)) {
			$this->apiResponseSchema->setMessage(
				ApiResponseTypeEnum::CHECK_INCORRECT,
				$this->translator->getTranslation('user@passwordIsIncorrect')
			);

			return new Response($this->apiResponseSchema, 'error', 400);
		}

		return $identifiedUser;

	}

	/**
	 * @param User             $identifiedUser
	 * @param AuthorizationDTO $authorizationDTO
	 *
	 * @return bool
	 */
	private function comparePassword(User $identifiedUser, AuthorizationDTO $authorizationDTO): bool
	{

		$passwordHashingService = new PasswordHashingService();

		return $passwordHashingService->compare(
			$authorizationDTO->password,
			$identifiedUser->getPassword()
		);

	}

}