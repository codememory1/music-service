<?php

namespace App\Controller\PublicAvailable;

use App\Dto\Transformer\AccountActivationTransformer;
use App\Dto\Transformer\AuthorizationTransformer;
use App\Dto\Transformer\RefreshTokenTransformer;
use App\Dto\Transformer\RegistrationTransformer;
use App\Enum\PlatformCodeEnum;
use App\Infrastructure\Validator\Validator;
use App\ResponseData\General\User\UserResponseData;
use App\ResponseData\Public\User\Session\UserSessionResponseData;
use App\Rest\Controller\AbstractRestController;
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
    public function registration(RegistrationTransformer $transformer, Registration $register, UserResponseData $responseData): JsonResponse
    {
        $responseData->setEntities($register->handle($transformer->transformFromRequest()));

        return $this->responseData($responseData, PlatformCodeEnum::CREATED_PENDING);
    }

    #[Route('/auth', methods: 'POST')]
    public function auth(
        AuthorizationTransformer $transformer,
        Validator $validator,
        Identification $identification,
        Authentication $authentication,
        Authorization $authorization
    ): JsonResponse {
        $dto = $transformer->transformFromRequest();

        $validator->validate($dto);

        $identifiedUser = $identification->identify($dto);
        $authenticatedUser = $authentication->authenticate($dto, $identifiedUser);

        return $this->response($authorization->auth($authenticatedUser));
    }

    #[Route('/access-token/update', methods: 'PUT')]
    public function updateAccessToken(RefreshTokenTransformer $transformer, UpdateAccessToken $updateAccessToken): JsonResponse
    {
        return $this->response($updateAccessToken->update($transformer->transformFromRequest()));
    }

    #[Route('/logout', methods: 'GET')]
    public function logout(RefreshTokenTransformer $transformer, Logout $logout, UserSessionResponseData $responseData): JsonResponse
    {
        $responseData->setEntities($logout->logout($transformer->transformFromRequest()));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }

    #[Route('/account-activation', methods: 'POST')]
    public function activationAccount(AccountActivationTransformer $transformer, AccountActivation $accountActivation, UserResponseData $responseData): JsonResponse
    {
        $responseData->setEntities($accountActivation->activate($transformer->transformFromRequest()));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }
}