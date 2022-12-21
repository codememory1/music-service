<?php

namespace App\Controller\PublicAvailable;

use App\Dto\Transformer\AccountActivationTransformer;
use App\Dto\Transformer\AuthorizationTransformer;
use App\Dto\Transformer\RefreshTokenTransformer;
use App\Dto\Transformer\RegistrationTransformer;
use App\Enum\PlatformCodeEnum;
use App\Infrastructure\Validator\Validator;
use App\ResponseData\General\User\UserAccountActivationResponseData;
use App\ResponseData\General\User\UserRegistrationResponseData;
use App\ResponseData\Public\User\Session\UserSessionResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\Security\AccountActivation\AccountActivation;
use App\Security\Auth\Authentication;
use App\Security\Auth\Authorization;
use App\Security\Auth\Identification;
use App\Security\Logout\Logout;
use App\Security\Registration\Registration;
use App\UseCase\User\Session\UpdateUserSessionAccessToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class SecurityController extends AbstractRestController
{
    #[Route('/register', methods: Request::METHOD_POST)]
    public function registration(RegistrationTransformer $transformer, Registration $register, UserRegistrationResponseData $responseData): HttpResponseCollectorInterface
    {
        return $this->responseData(
            $responseData,
            $register->registration($transformer->transformFromRequest()),
            PlatformCodeEnum::CREATED_PENDING
        );
    }

    #[Route('/auth', methods: Request::METHOD_POST)]
    public function auth(
        AuthorizationTransformer $transformer,
        Validator $validator,
        Identification $identification,
        Authentication $authentication,
        Authorization $authorization
    ): HttpResponseCollectorInterface {
        $dto = $transformer->transformFromRequest();

        $validator->validate($dto);

        $identifiedUser = $identification->identify($dto);
        $authenticatedUser = $authentication->authenticate($dto, $identifiedUser);

        return $this->response($authorization->auth($authenticatedUser));
    }

    #[Route('/access-token/update', methods: Request::METHOD_PUT)]
    public function updateAccessToken(RefreshTokenTransformer $transformer, UpdateUserSessionAccessToken $updateUserSessionAccessToken): HttpResponseCollectorInterface
    {
        return $this->response($updateUserSessionAccessToken->process($transformer->transformFromRequest()));
    }

    #[Route('/logout', methods: Request::METHOD_GET)]
    public function logout(RefreshTokenTransformer $transformer, Logout $logout, UserSessionResponseData $responseData): HttpResponseCollectorInterface
    {
        return $this->responseData($responseData, $logout->logout($transformer->transformFromRequest()), PlatformCodeEnum::DELETED);
    }

    #[Route('/account-activation', methods: Request::METHOD_POST)]
    public function activationAccount(
        AccountActivationTransformer $transformer,
        AccountActivation $accountActivation,
        UserAccountActivationResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData(
            $responseData,
            $accountActivation->activate($transformer->transformFromRequest()),
            PlatformCodeEnum::UPDATED
        );
    }
}