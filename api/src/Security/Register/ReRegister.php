<?php

namespace App\Security\Register;

use App\Dto\Transfer\RegistrationDto;
use App\Entity\User;

final class ReRegister
{
    public function make(RegistrationDto $dto, User $user): void
    {
        $user->getProfile()->setPseudonym($dto->pseudonym);
    }
}