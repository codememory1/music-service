<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\DTO\RequestRestorationPasswordDTO;
use App\Rest\Controller\AbstractRestController;
use App\Security\PasswordReset\RequestRestoration;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PasswordResetController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/password-reset')]
class PasswordResetController extends AbstractRestController
{
    /**
     * @param RequestRestorationPasswordDTO $requestRestorationPasswordDTO
     * @param RequestRestoration            $requestRestoration
     *
     * @return JsonResponse
     */
    #[Route('/request-restoration', methods: 'POST')]
    #[Authorization(false)]
    public function requestRestoration(RequestRestorationPasswordDTO $requestRestorationPasswordDTO, RequestRestoration $requestRestoration): JsonResponse
    {
        return $requestRestoration->send($requestRestorationPasswordDTO->collect());
    }
}