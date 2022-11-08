<?php

namespace App\Controller\PublicAvailable;

use App\Dto\Transformer\AccountActivationTransformer;
use App\Dto\Transformer\AuthorizationTransformer;
use App\Dto\Transformer\RefreshTokenTransformer;
use App\Dto\Transformer\RegistrationTransformer;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Validator\HttpValidator;
use App\Security\AccountActivation\AccountActivation;
use App\Security\Auth\Authentication;
use App\Security\Auth\Authorization;
use App\Security\Auth\Identification;
use App\Security\Logout\Logout;
use App\Security\Register\Registration;
use App\Service\UserSession\UpdateAccessToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class SecurityController extends AbstractRestController
{
    #[Route('/register', methods: 'POST')]
    public function registration(RegistrationTransformer $registrationTransformer, Registration $register): JsonResponse
    {
        return $register->handle($registrationTransformer->transformFromRequest());
    }

    #[Route('/auth', methods: 'POST')]
    public function auth(
        AuthorizationTransformer $authorizationTransformer,
        HttpValidator $validator,
        Identification $identification,
        Authentication $authentication,
        Authorization $authorization
    ): JsonResponse {
        $authorizationDto = $authorizationTransformer->transformFromRequest();

        $validator->validate($authorizationDto);

        $identifiedUser = $identification->identify($authorizationDto);
        $authenticatedUser = $authentication->authenticate($authorizationDto, $identifiedUser);

        return $this->response($authorization->auth($authenticatedUser));
    }

    #[Route('/access-token/update', methods: 'PUT')]
    public function updateAccessToken(RefreshTokenTransformer $refreshTokenTransformer, UpdateAccessToken $updateAccessTokenService): JsonResponse
    {
        return $updateAccessTokenService->request($refreshTokenTransformer->transformFromRequest());
    }

    #[Route('/logout', methods: 'GET')]
    public function logout(RefreshTokenTransformer $refreshTokenTransformer, Logout $logout): JsonResponse
    {
        return $logout->logout($refreshTokenTransformer->transformFromRequest());
    }

    #[Route('/account-activation', methods: 'POST')]
    public function activationAccount(AccountActivationTransformer $accountActivationTransformer, AccountActivation $accountActivation): JsonResponse
    {
        return $accountActivation->activate($accountActivationTransformer->transformFromRequest());
    }
}