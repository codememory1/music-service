<?php

namespace App\Security\PasswordReset;

use App\DTO\PasswordRecoveryRequestDTO;
use App\Entity\PasswordReset;
use App\Security\AbstractSecurity;

/**
 * Class CreatorToken.
 *
 * @package App\Security\PasswordReset
 *
 * @author  Codememory
 */
class CreatorToken extends AbstractSecurity
{
    /**
     * @param PasswordRecoveryRequestDTO $passwordRecoveryRequestDTO
     *
     * @return PasswordReset
     */
    public function create(PasswordRecoveryRequestDTO $passwordRecoveryRequestDTO): PasswordReset
    {
        /** @var PasswordReset $passwordResetEntity */
        $passwordResetEntity = $passwordRecoveryRequestDTO->getCollectedEntity();

        $this->em->persist($passwordResetEntity);
        $this->em->flush();

        return $passwordResetEntity;
    }
}