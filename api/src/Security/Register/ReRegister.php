<?php

namespace App\Security\Register;

use App\Dto\Transfer\RegistrationDto;
use App\Entity\User;
use App\Service\AbstractService;

class ReRegister extends AbstractService
{
    public function make(RegistrationDto $registrationDto, User $user): void
    {
        $user->getProfile()->setPseudonym($registrationDto->pseudonym);
    }
}