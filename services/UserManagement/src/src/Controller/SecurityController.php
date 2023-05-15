<?php

namespace App\Controller;

use App\DTO\Open\AccountActivationDTO;
use App\DTO\Open\AuthorizationDTO;
use App\DTO\Open\RegistrationDTO;
use App\Entity\User;
use App\Exceptions\BadException;
use App\ResponseControl\Open\RegisteredUserResponseControl;
use App\ResponseControl\Open\TokenPairResponseControl;
use App\UseCase\AccountActivation\ActivateAccount;
use App\UseCase\Auth\Authorization;
use App\UseCase\Register\Registration;
use Codememory\ApiBundle\Controller\AbstractController;
use Codememory\ApiBundle\Exceptions\HttpException;
use Codememory\ApiBundle\ResponseSchema\Interfaces\ResponseSchemaInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/security')]
final class SecurityController extends AbstractController
{
    /**
     * @throws HttpException
     * @throws BadException
     */
    #[Route('/auth', methods: Request::METHOD_POST)]
    public function auth(AuthorizationDTO $dto, Authorization $authorization, TokenPairResponseControl $responseControl): ResponseSchemaInterface
    {
        $this->prepareDTO($dto);

        return $this->responseControl(200, $responseControl->setData($authorization->process($dto)));
    }

    /**
     * @throws HttpException
     */
    #[Route('/register', methods: Request::METHOD_POST)]
    public function register(RegistrationDTO $dto, Registration $registration, RegisteredUserResponseControl $responseControl): ResponseSchemaInterface
    {
        $this->prepareDTO($dto, new User());

        return $this->responseControl(200, $responseControl->setData($registration->process($dto)));
    }

    /**
     * @throws BadException
     * @throws HttpException
     */
    #[Route('/activate-account', methods: Request::METHOD_POST)]
    public function activateAccount(AccountActivationDTO $dto, ActivateAccount $activateAccount, RegisteredUserResponseControl $responseControl): ResponseSchemaInterface
    {
        $this->prepareDTO($dto);

        return $this->responseControl(200, $responseControl->setData($activateAccount->process($dto)));
    }
}