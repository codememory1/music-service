<?php

namespace App\Security\Register;

use App\DTO\RegistrationDTO;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Register
 *
 * @package App\Security\Register
 *
 * @author  Codememory
 */
class Register extends AbstractService
{
    public function register(RegistrationDTO $registrationDTO): JsonResponse
    {
        if (false === $this->validate($registrationDTO)) {
            return $this->validator->getResponse();
        }
    }
}