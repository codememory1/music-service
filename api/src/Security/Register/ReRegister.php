<?php

namespace App\Security\Register;

use App\Dto\Transfer\RegistrationDto;
use App\Entity\User;

class ReRegister
{
    public function make(RegistrationDto $registrationDto, User $user): void
    {
        $user->getProfile()->setPseudonym($registrationDto->pseudonym);
    }
}