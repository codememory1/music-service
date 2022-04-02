<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\ApiController;
use App\DTO\AuthorizationDTO;
use App\DTO\PasswordRecoveryRequestDTO;
use App\DTO\RegistrationDTO;
use App\Entity\User;
use App\Enum\EventsEnum;
use App\Event\UserRegistrationEvent;
use App\Exception\UndefinedClassForDTOException;
use App\Rest\Http\Request;
use App\Rest\Http\Response;
use App\Security\Auth\Authentication;
use App\Security\Auth\Authorization;
use App\Security\Auth\Identification;
use App\Security\Auth\Validation as AuthValidation;
use App\Security\ConfirmationRegistration\DeleterToken;
use App\Security\ConfirmationRegistration\UserActivation;
use App\Security\Registration\CreatorAccount;
use App\Security\Registration\Registration;
use App\Security\Registration\Validation as RegisterValidation;
use App\Service\Security\PasswordReset\RecoveryRequestService;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
class SecurityController extends ApiController
{

	/**
	 * @param Request                  $request
	 * @param RegisterValidation       $validation
	 * @param Registration             $registration
	 * @param CreatorAccount           $creatorAccount
	 * @param EventDispatcherInterface $eventDispatcher
	 *
	 * @return JsonResponse
	 */
	#[Route('/register', methods: 'POST')]
	public function register(
		Request $request,
		RegisterValidation $validation,
		Registration $registration,
		CreatorAccount $creatorAccount,
		EventDispatcherInterface $eventDispatcher
	): JsonResponse
	{

		$registrationDTO = new RegistrationDTO($request, $this->managerRegistry);

		/** @var User $userEntity */
		$userEntity = $registrationDTO->getCollectedEntity();

		// Validation of input post data
		if (true !== $inputValidationResponse = $validation->validate($registrationDTO)) {
			return $inputValidationResponse->make();
		}

		// Checking for the existence of an unactivated account
		if (false !== $finedUser = $registration->isReRegistration($registrationDTO)) {
			$createdAccount = $creatorAccount->reCreate($registrationDTO, $finedUser);
		} else {
			// Entity validation, i.e. checking the existence of an activated account
			if (true !== $entityValidationResponse = $validation->validate($userEntity)) {
				return $entityValidationResponse->make();
			}

			// Create a new user account
			$createdAccount = $creatorAccount->create($registrationDTO);
		}

		$eventDispatcher->dispatch(
			new UserRegistrationEvent($createdAccount),
			EventsEnum::USER_REGISTRATION->value
		);

		return $registration->successAuthResponse()->make();
	}

	/**
	 * @param UserActivation $userActivation
	 * @param DeleterToken   $deleterToken
	 * @param string         $token
	 *
	 * @return JsonResponse
	 */
	#[Route('/activate-account/{token<.+>}', methods: 'GET')]
	public function activateAccount(
		UserActivation $userActivation,
		DeleterToken $deleterToken,
		string $token
	): JsonResponse
	{

		// Checking the validity of the token
		if (true !== $response = $userActivation->isValid($token)) {
			return $response->make();
		}

		// Account activation and activation token removal
		$deleterToken->delete($userActivation->activate($token));

		return $userActivation->successActivationResponse()->make();

	}

	/**
	 * @param Request        $request
	 * @param AuthValidation $validation
	 * @param Identification $identification
	 * @param Authentication $authentication
	 * @param Authorization  $authorization
	 *
	 * @return JsonResponse
	 * @throws NonUniqueResultException
	 */
	#[Route('/auth', methods: 'POST')]
	public function auth(
		Request $request,
		AuthValidation $validation,
		Identification $identification,
		Authentication $authentication,
		Authorization $authorization
	): JsonResponse
	{

		$authorizationDTO = new AuthorizationDTO($request, $this->managerRegistry);

		// Validation of input post data
		if (true !== $resultValidation = $validation->validate($authorizationDTO)) {
			return $resultValidation->make();
		}

		// User identification
		$identifiedUser = $identification->identify($authorizationDTO);

		if ($identifiedUser instanceof Response) {
			return $identifiedUser->make();
		}

		// User authentication
		$authenticatedUser = $authentication->authenticate($identifiedUser, $authorizationDTO);

		if ($authenticatedUser instanceof Response) {
			return $authenticatedUser->make();
		}

		// User authorization
		return $authorization->auth($identifiedUser, $authorizationDTO)->make();

	}

	/**
	 * @param RecoveryRequestService $recoveryRequestService
	 * @param Request                $request
	 *
	 * @return JsonResponse
	 * @throws UndefinedClassForDTOException
	 */
	#[Route('/password-reset/recovery-request', methods: 'POST')]
	public function recoveryRequest(RecoveryRequestService $recoveryRequestService, Request $request): JsonResponse
	{

		return $recoveryRequestService
			->send(new PasswordRecoveryRequestDTO($request))
			->make();

	}

}