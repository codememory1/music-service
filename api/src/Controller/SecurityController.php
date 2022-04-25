<?php

namespace App\Controller;

use App\DTO\AuthorizationDTO;
use App\DTO\PasswordRecoveryRequestDTO;
use App\DTO\RegistrationDTO;
use App\DTO\UserChangePasswordDTO;
use App\Entity\PasswordReset;
use App\Enum\EventEnum;
use App\Event\PasswordRecoveryRequestEvent;
use App\Event\UserPasswordChangeEvent;
use App\Rest\ApiController;
use App\Rest\Http\Response;
use App\Rest\Validator\Validator;
use App\Security\Auth\Authentication;
use App\Security\Auth\Authorization;
use App\Security\ConfirmationRegistration\UserActivation;
use App\Security\PasswordReset\PasswordChanger\Changer;
use App\Security\PasswordReset\PasswordChanger\Identification as PasswordResetIdentification;
use App\Security\PasswordReset\RecoveryRequest;
use App\Security\Registration\Register;
use App\Security\User\Identification as UserIdentification;
use App\Security\User\UpdaterPassword;
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
     * @param EventDispatcherInterface $eventDispatcher
     * @param Register                 $registration
     *
     * @return JsonResponse
     */
    #[Route('/register', methods: 'POST')]
    public function register(RegistrationDTO $registrationDTO, EventDispatcherInterface $eventDispatcher, Register $registration): JsonResponse
    {
        $registeredUser = $registration->register($registrationDTO, $eventDispatcher);

        if ($registeredUser instanceof Response) {
            return $registeredUser->make();
        }

        return $registration->successRegisterResponse()->make();
    }

    /**
     * @param UserActivation           $userActivation
     * @param EventDispatcherInterface $eventDispatcher
     * @param string                   $token
     *
     * @return JsonResponse
     */
    #[Route('/activate-account/{token<.+>}', methods: 'GET')]
    public function activateAccount(UserActivation $userActivation, EventDispatcherInterface $eventDispatcher, string $token): JsonResponse
    {
        $tokenActivation = $userActivation->handle($eventDispatcher, $token);

        if ($tokenActivation instanceof Response) {
            return $tokenActivation->make();
        }

        return $userActivation->successActivationResponse()->make();
    }

    /**
     * @param AuthorizationDTO   $authorizationDTO
     * @param Validator          $validator
     * @param UserIdentification $identification
     * @param Authentication     $authentication
     * @param Authorization      $authorization
     *
     * @return JsonResponse
     */
    #[Route('/auth', methods: 'POST')]
    public function auth(
        AuthorizationDTO $authorizationDTO,
        Validator $validator,
        UserIdentification $identification,
        Authentication $authentication,
        Authorization $authorization
    ): JsonResponse {
        // Validation of input post data
        if (false === $validator->validate($authorizationDTO)->isValidate()) {
            return $validator->getResponse()->make();
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
        $tokens = $authorization->auth($identifiedUser);

        return $authorization->successAuthResponse([
            'access_token' => $tokens->getAccessToken(),
            'refresh_token' => $tokens->getRefreshToken()
        ])->make();
    }

    /**
     * @param PasswordRecoveryRequestDTO $passwordRecoveryRequestDTO
     * @param Validator                  $validator
     * @param UserIdentification         $identification
     * @param EventDispatcherInterface   $eventDispatcher
     * @param RecoveryRequest            $recoveryRequest
     *
     * @return JsonResponse
     */
    #[Route('/password-reset/recovery-request', methods: 'POST')]
    public function recoveryRequest(
        PasswordRecoveryRequestDTO $passwordRecoveryRequestDTO,
        Validator $validator,
        UserIdentification $identification,
        EventDispatcherInterface $eventDispatcher,
        RecoveryRequest $recoveryRequest,
    ): JsonResponse {
        /** @var PasswordReset $passwordResetEntity */
        $passwordResetEntity = $passwordRecoveryRequestDTO->getCollectedEntity();

        // Validation of input post data
        if (false === $validator->validate($passwordRecoveryRequestDTO)->isValidate()) {
            return $validator->getResponse()->make();
        }

        // User identification
        $identifiedUser = $identification->identify($passwordRecoveryRequestDTO);

        if ($identifiedUser instanceof Response) {
            return $identifiedUser->make();
        }

        $eventDispatcher->dispatch(
            new PasswordRecoveryRequestEvent($identifiedUser, $passwordResetEntity),
            EventEnum::PASSWORD_RECOVERY_REQUEST->value
        );

        return $recoveryRequest->successRecoveryRequest()->make();
    }

    /**
     * @param UserChangePasswordDTO       $userChangePasswordDTO
     * @param Validator                   $validator
     * @param PasswordResetIdentification $identification
     * @param Changer                     $changer
     * @param EventDispatcherInterface    $eventDispatcher
     * @param UpdaterPassword             $updaterPassword
     * @param string                      $token
     *
     * @return JsonResponse
     */
    #[Route('/password-reset/change/{token<.+>}', methods: 'POST')]
    public function passwordRecovery(
        UserChangePasswordDTO $userChangePasswordDTO,
        Validator $validator,
        PasswordResetIdentification $identification,
        Changer $changer,
        EventDispatcherInterface $eventDispatcher,
        UpdaterPassword $updaterPassword,
        string $token
    ): JsonResponse {
        // Validation of input post data
        if (false === $validator->validate($userChangePasswordDTO)->isValidate()) {
            return $validator->getResponse()->make();
        }

        // Password reset identification
        $identifiedPasswordReset = $identification->identify($token);

        if ($identifiedPasswordReset instanceof Response) {
            return $identifiedPasswordReset->make();
        }

        // Change Password
        $changer->change($userChangePasswordDTO, $identifiedPasswordReset);

        $eventDispatcher->dispatch(
            new UserPasswordChangeEvent($identifiedPasswordReset->getUser()),
            EventEnum::USER_PASSWORD_CHANGE->value
        );

        return $updaterPassword->successChangePasswordResponse()->make();
    }
}