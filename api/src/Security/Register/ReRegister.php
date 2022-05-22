<?php

namespace App\Security\Register;

use App\DTO\RegistrationDTO;
use App\Entity\User;
use App\Service\AbstractService;

/**
 * Class ReRegister.
 *
 * @package App\Security\Register
 *
 * @author  Codememory
 */
class ReRegister extends AbstractService
{
    /**
     * @param RegistrationDTO $registrationDTO
     * @param User            $user
     *
     * @return void
     */
    public function make(RegistrationDTO $registrationDTO, User $user): void
    {
        $user->getProfile()->setPseudonym($registrationDTO->pseudonym);

        $this->em->flush();
    }
}