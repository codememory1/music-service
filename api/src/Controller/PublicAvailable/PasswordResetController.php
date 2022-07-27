<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\DTO\RequestRestorationPasswordDTO;
use App\DTO\RestorePasswordDTO;
use App\Rest\Controller\AbstractRestController;
use App\Security\PasswordReset\RequestRestoration;
use App\Security\PasswordReset\RestorePassword;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PasswordResetController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/user/password-reset')]
#[Authorization(false)]
class PasswordResetController extends AbstractRestController
{
    #[Route('/request-restoration', methods: 'POST')]
    public function requestRestoration(RequestRestorationPasswordDTO $requestRestorationPasswordDTO, RequestRestoration $requestRestoration): JsonResponse
    {
        return $requestRestoration->send($requestRestorationPasswordDTO->collect());
    }

    #[Route('/restore-password', methods: 'POST')]
    public function restorePassword(RestorePasswordDTO $restorePasswordDTO, RestorePassword $restorePassword): JsonResponse
    {
        return $restorePassword->restore($restorePasswordDTO->collect());
    }
}