<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Dto\Transformer\RequestRestorationPasswordTransformer;
use App\Dto\Transformer\RestorePasswordTransformer;
use App\Enum\PlatformCodeEnum;
use App\ResponseData\General\PasswordReset\RequestRestorationResponseData;
use App\ResponseData\General\PasswordReset\RestoreResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Security\PasswordReset\RequestRestoration;
use App\Security\PasswordReset\RestorePassword;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/password-reset')]
#[Authorization(false)]
class PasswordResetController extends AbstractRestController
{
    #[Route('/request-restoration', methods: 'POST')]
    public function requestRestoration(
        RequestRestorationPasswordTransformer $transformer,
        RequestRestoration $requestRestoration,
        RequestRestorationResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($requestRestoration->send($transformer->transformFromRequest()));

        return $this->responseData($responseData, PlatformCodeEnum::CREATED);
    }

    #[Route('/restore-password', methods: 'POST')]
    public function restorePassword(
        RestorePasswordTransformer $transformer,
        RestorePassword $restorePassword,
        RestoreResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($restorePassword->restore($transformer->transformFromRequest()));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }
}