<?php

namespace App\Controller\PublicAvailable;

use App\DTO\RegistrationDTO;
use App\Rest\Controller\AbstractRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityController
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
class SecurityController extends AbstractRestController
{
    #[Route('/register', methods: 'POST')]
    public function registration(RegistrationDTO $registrationDTO): JsonResponse
    {
        dd($registrationDTO->collect()->email);
    }
}