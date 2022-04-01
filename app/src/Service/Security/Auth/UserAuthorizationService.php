<?php

namespace App\Service\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Enum\ApiResponseTypeEnum;
use App\Enum\StatusEnum;
use App\Rest\ApiService;
use App\Rest\Http\Response;
use Doctrine\ORM\NonUniqueResultException;
use Exception;

/**
 * Class UserAuthorizationService
 *
 * @package App\Service\Security\Auth
 *
 * @author  Codememory
 */
class UserAuthorizationService extends ApiService
{

	/**
	 * @param AuthorizationDTO          $authorizationDTO
	 * @param UserIdentificationService $userIdentificationService
	 * @param UserAuthenticationService $userAuthenticationService
	 * @param CreatorUserSessionService $creatorUserSessionService
	 *
	 * @return Response
	 * @throws NonUniqueResultException
	 * @throws Exception
	 */
	public function authorize(
		AuthorizationDTO $authorizationDTO,
		UserIdentificationService $userIdentificationService,
		UserAuthenticationService $userAuthenticationService,
		CreatorUserSessionService $creatorUserSessionService
	): Response
	{

		// Validation of input POST data
		if (true !== $resultInputValidation = $this->inputValidation($authorizationDTO)) {
			return $resultInputValidation;
		}

		// Check identify user
		$identifiedUser = $userIdentificationService->identify($authorizationDTO);

		if ($identifiedUser instanceof Response) {
			return $identifiedUser;
		}

		// Check status
		if (true !== $resultCheckActive = $this->checkActivity($identifiedUser)) {
			return $resultCheckActive;
		}

		// Check authentication user
		$authenticationUser = $userAuthenticationService->authenticate($identifiedUser, $authorizationDTO);

		if ($authenticationUser instanceof Response) {
			return $authenticationUser;
		}

		// Create user session
		$createdUserSession = $this->createSession($identifiedUser, $authorizationDTO, $creatorUserSessionService);

		return $this->getSuccessResponse($createdUserSession);

	}

	/**
	 * @param User $identityUser
	 *
	 * @return Response|bool
	 * @throws Exception
	 */
	private function checkActivity(User $identityUser): Response|bool
	{

		if ($identityUser->getStatus() !== StatusEnum::ACTIVE->value) {
			$this->apiResponseSchema->setMessage(
				ApiResponseTypeEnum::CHECK_ACTIVE,
				$this->getTranslation('user@accountNotActive')
			);

			return new Response($this->apiResponseSchema, 'error', 400);
		}

		return true;

	}

	/**
	 * @param User                      $identifiedUser
	 * @param AuthorizationDTO          $authorizationDTO
	 * @param CreatorUserSessionService $creatorUserSessionService
	 *
	 * @return CreatorUserSessionService
	 */
	private function createSession(User $identifiedUser, AuthorizationDTO $authorizationDTO, CreatorUserSessionService $creatorUserSessionService): CreatorUserSessionService
	{

		$creatorUserSessionService->create($identifiedUser, $authorizationDTO);

		return $creatorUserSessionService;

	}

	/**
	 * @param CreatorUserSessionService $createdUserSession
	 *
	 * @return Response
	 */
	private function getSuccessResponse(CreatorUserSessionService $createdUserSession): Response
	{

		$this->apiResponseSchema
			->setMessage(ApiResponseTypeEnum::CHECK_AUTH, $this->getTranslation('user@successAuth'))
			->setData([
				'access_token'  => $createdUserSession->getAccessToken(),
				'refresh_token' => $createdUserSession->getRefreshToken()
			]);

		return new Response($this->apiResponseSchema, 'success', 200);

	}

}