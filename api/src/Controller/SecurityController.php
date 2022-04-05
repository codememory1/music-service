<?php

namespace App\Controller;

use App\DTO\AuthorizationDTO;
use App\DTO\PasswordRecoveryRequestDTO;
use App\DTO\RegistrationDTO;
use App\Entity\PasswordReset;
use App\Entity\User;
use App\Enum\EventsEnum;
use App\Event\PasswordRecoveryRequestEvent;
use App\Event\UserRegistrationEvent;
use App\Rest\ApiController;
use App\Rest\Http\Response;
use App\Security\Auth\Authentication;
use App\Security\Auth\Authorization;
use App\Security\Auth\Validation as AuthValidation;
use App\Security\ConfirmationRegistration\DeleterToken;
use App\Security\ConfirmationRegistration\UserActivation;
use App\Security\PasswordReset\RecoveryRequest;
use App\Security\PasswordReset\Validation as PasswordResetValidation;
use App\Security\Registration\CreatorAccount;
use App\Security\Registration\Registration;
use App\Security\Registration\Validation as RegisterValidation;
use App\Security\User\Identification;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityController.
 *
 * @package App\Controller
 *
 * @author  Codememory
 */
class SecurityController extends ApiController
{
    /**
     * @param RegistrationDTO          $registrationDTO
     * @param RegisterValidation       $validation
     * @param Registration             $registration
     * @param CreatorAccount           $creatorAccount
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return JsonResponse
     */
    #[Route('/register', methods: 'POST')]
    public function register(
        RegistrationDTO $registrationDTO,
        RegisterValidation $validation,
        Registration $registration,
        CreatorAccount $creatorAccount,
        EventDispatcherInterface $eventDispatcher
    ): JsonResponse {
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

        return $registration->successRegisterResponse()->make();
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
    ): JsonResponse {
        // Checking the validity of the token
        if (true !== $response = $userActivation->isValid($token)) {
            return $response->make();
        }

        // Account activation and activation token removal
        $deleterToken->delete($userActivation->activate($token));

        return $userActivation->successActivationResponse()->make();
    }

    /**
     * @param AuthorizationDTO $authorizationDTO
     * @param AuthValidation   $validation
     * @param Identification   $identification
     * @param Authentication   $authentication
     * @param Authorization    $authorization
     *
     * @throws NonUniqueResultException
     *
     * @return JsonResponse
     */
    #[Route('/auth', methods: 'POST')]
    public function auth(
        AuthorizationDTO $authorizationDTO,
        AuthValidation $validation,
        Identification $identification,
        Authentication $authentication,
        Authorization $authorization
    ): JsonResponse {
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
        $tokens = $authorization->auth($identifiedUser, $authorizationDTO);

        return $authorization->successAuthResponse($tokens)->make();
    }

    /**
     * @param PasswordRecoveryRequestDTO $passwordRecoveryRequestDTO
     * @param PasswordResetValidation    $validation
     * @param Identification             $identification
     * @param EventDispatcherInterface   $eventDispatcher
     * @param RecoveryRequest            $recoveryRequest
     *
     * @throws NonUniqueResultException
     *
     * @return JsonResponse
     */
    #[Route('/password-reset/recovery-request', methods: 'POST')]
    public function recoveryRequest(
        PasswordRecoveryRequestDTO $passwordRecoveryRequestDTO,
        PasswordResetValidation $validation,
        Identification $identification,
        EventDispatcherInterface $eventDispatcher,
        RecoveryRequest $recoveryRequest,
    ): JsonResponse {
        /** @var PasswordReset $passwordResetEntity */
        $passwordResetEntity = $passwordRecoveryRequestDTO->getCollectedEntity();

        // Validation of input post data
        if (true !== $resultValidation = $validation->validate($passwordRecoveryRequestDTO)) {
            return $resultValidation->make();
        }

        // User identification
        $identifiedUser = $identification->identify($passwordRecoveryRequestDTO);

        if ($identifiedUser instanceof Response) {
            return $identifiedUser->make();
        }

        $eventDispatcher->dispatch(
            new PasswordRecoveryRequestEvent($identifiedUser, $passwordResetEntity),
            EventsEnum::PASSWORD_RECOVERY_REQUEST->value
        );

        return $recoveryRequest->successRecoveryRequest()->make();
    }
}