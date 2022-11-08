<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Dto\Transformer\RequestRestorationPasswordTransformer;
use App\Dto\Transformer\RestorePasswordTransformer;
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
    public function requestRestoration(RequestRestorationPasswordTransformer $transformer, RequestRestoration $requestRestoration): JsonResponse
    {
        return $requestRestoration->send($transformer->transformFromRequest());
    }

    #[Route('/restore-password', methods: 'POST')]
    public function restorePassword(RestorePasswordTransformer $transformer, RestorePassword $restorePassword): JsonResponse
    {
        return $restorePassword->restore($transformer->transformFromRequest());
    }
}