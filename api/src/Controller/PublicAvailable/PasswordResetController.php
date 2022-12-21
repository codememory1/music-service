<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Dto\Transformer\RequestRestorationPasswordTransformer;
use App\Dto\Transformer\RestorePasswordTransformer;
use App\Enum\PlatformCodeEnum;
use App\ResponseData\General\PasswordReset\RequestRestorationResponseData;
use App\ResponseData\General\PasswordReset\RestoreResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\Security\PasswordReset\RequestRestoration;
use App\Security\PasswordReset\RestorePassword;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/password-reset')]
#[Authorization(false)]
class PasswordResetController extends AbstractRestController
{
    #[Route('/request-restoration', methods: Request::METHOD_POST)]
    public function requestRestoration(
        RequestRestorationPasswordTransformer $transformer,
        RequestRestoration $requestRestoration,
        RequestRestorationResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData(
            $responseData,
            $requestRestoration->send($transformer->transformFromRequest()),
            PlatformCodeEnum::CREATED
        );
    }

    #[Route('/restore-password', methods: Request::METHOD_POST)]
    public function restorePassword(
        RestorePasswordTransformer $transformer,
        RestorePassword $restorePassword,
        RestoreResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData(
            $responseData,
            $restorePassword->restore($transformer->transformFromRequest()),
            PlatformCodeEnum::UPDATED
        );
    }
}