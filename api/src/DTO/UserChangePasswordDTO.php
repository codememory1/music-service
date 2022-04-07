<?php

namespace App\DTO;

use App\Rest\DTO\AbstractDTO;
use App\Traits\DTO\PasswordConfirmTrait;
use App\Traits\DTO\PasswordTrait;

/**
 * Class UserChangePasswordDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class UserChangePasswordDTO extends AbstractDTO
{
    use PasswordTrait;

    use PasswordConfirmTrait;

    /**
     * @inheritDoc
     */
    public function wrapper(): void
    {
        $this
            ->addExpectedRequestKey('password')
            ->addExpectedRequestKey('password_confirm', 'passwordConfirm');
    }
}