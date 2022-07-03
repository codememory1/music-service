<?php

namespace App\Security\Register;

use App\DTO\RegistrationDTO;
use App\Entity\User;
use App\Service\AbstractService;

/**
 * Class ReRegister.
 *
 * @package App\Security\Registration
 *
 * @author  Codememory
 */
class ReRegister extends AbstractService
{
    public function make(RegistrationDTO $registrationDTO, User $user): void
    {
        $user->getProfile()->setPseudonym($registrationDTO->pseudonym);
    }
}