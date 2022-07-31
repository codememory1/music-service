<?php

namespace App\Security\Register;

use App\Dto\Transfer\RegistrationDto;
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
    public function make(RegistrationDto $registrationDto, User $user): void
    {
        $user->getProfile()->setPseudonym($registrationDto->pseudonym);
    }
}