<?php

namespace App\Security\PasswordReset\PasswordChanger;

use App\DTO\UserChangePasswordDTO;
use App\Entity\PasswordReset;
use App\Enum\PasswordResetStatusEnum;
use App\Security\AbstractSecurity;
use App\Security\User\UpdaterPassword;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class Changer.
 *
 * @package App\Security\PasswordReset\PasswordChanger
 *
 * @author  Codememory
 */
class Changer extends AbstractSecurity
{
    /**
     * @var null|UpdaterPassword
     */
    private ?UpdaterPassword $updaterPassword = null;

    /**
     * @param UpdaterPassword $updaterPassword
     *
     * @return $this
     */
    #[Required]
    public function setUpdaterPassword(UpdaterPassword $updaterPassword): self
    {
        $this->updaterPassword = $updaterPassword;

        return $this;
    }

    /**
     * @param UserChangePasswordDTO $userChangePasswordDTO
     * @param PasswordReset         $passwordReset
     *
     * @return PasswordReset
     */
    public function change(UserChangePasswordDTO $userChangePasswordDTO, PasswordReset $passwordReset): PasswordReset
    {
        $passwordReset->setStatus(PasswordResetStatusEnum::RESET);

        $this->updaterPassword->update($userChangePasswordDTO, $passwordReset->getUser());

        return $passwordReset;
    }
}