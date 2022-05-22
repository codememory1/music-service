<?php

namespace App\Controller\PublicAvailable;

use App\DTO\RegistrationDTO;
use App\Rest\Controller\AbstractRestController;
use App\Security\Register\Register;
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
     * @param Register        $register
     *
     * @return JsonResponse
     */
    #[Route('/register', methods: 'POST')]
    public function registration(RegistrationDTO $registrationDTO, Register $register): JsonResponse
    {
        return $register->register($registrationDTO->collect());
    }
}