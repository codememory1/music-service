<?php

namespace App\Controller\PublicAvailable;

use App\DTO\RegistrationDTO;
use App\Rest\Controller\AbstractRestController;
use App\Security\Register\Registration;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
class SecurityController extends AbstractRestController
{
    /**
     * @param RegistrationDTO $registrationDTO
     * @param Registration    $register
     *
     * @return JsonResponse
     */
    #[Route('/register', methods: 'POST')]
    public function registration(RegistrationDTO $registrationDTO, Registration $register): JsonResponse
    {
        return $register->handle($registrationDTO->collect());
    }
}