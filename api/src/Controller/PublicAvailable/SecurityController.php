<?php

namespace App\Controller\PublicAvailable;

use App\DTO\AccountActivationDTO;
use App\DTO\AuthorizationDTO;
use App\DTO\RefreshTokenDTO;
use App\DTO\RegistrationDTO;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Validator\Validator;
use App\Security\AccountActivation\AccountActivation;
use App\Security\Auth\Authentication;
use App\Security\Auth\Authorization;
use App\Security\Auth\Identification;
use App\Security\Logout\Logout;
use App\Security\Register\Registration;
use App\Service\UserSession\UpdateAccessTokenService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/user')]
class SecurityController extends AbstractRestController
{
    #[Route('/register', methods: 'POST')]
    public function registration(RegistrationDTO $registrationDTO, Registration $register): JsonResponse
    {
        return $register->handle($registrationDTO->collect());
    }

    #[Route('/auth', methods: 'POST')]
    public function auth(
        AuthorizationDTO $authorizationDTO,
        Validator $validator,
        Identification $identification,
        Authentication $authentication,
        Authorization $authorization
    ): JsonResponse {
        $authorizationDTO->collect();

        if (false === $validator->validate($authorizationDTO)) {
            return $validator->getResponse();
        }

        $identifiedUser = $identification->identify($authorizationDTO);
        $authenticatedUser = $authentication->authenticate($authorizationDTO, $identifiedUser);

        return $authorization->auth($authenticatedUser);
    }

    #[Route('/access-token/update', methods: 'PUT')]
    public function updateAccessToken(RefreshTokenDTO $refreshTokenDTO, UpdateAccessTokenService $updateAccessTokenService): JsonResponse
    {
        return $updateAccessTokenService->make($refreshTokenDTO->collect());
    }

    #[Route('/logout', methods: 'GET')]
    public function logout(RefreshTokenDTO $refreshTokenDTO, Logout $logout): JsonResponse
    {
        return $logout->logout($refreshTokenDTO->collect());
    }

    #[Route('/account-activation', methods: 'POST')]
    public function activationAccount(AccountActivationDTO $accountActivationDTO, AccountActivation $accountActivation): JsonResponse
    {
        return $accountActivation->activate($accountActivationDTO->collect());
    }
}