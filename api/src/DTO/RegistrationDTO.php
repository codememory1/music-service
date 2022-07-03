<?php

namespace App\DTO;

use App\DTO\Traits\SetPasswordTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RegistrationDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class RegistrationDTO extends AbstractDTO
{
    use SetPasswordTrait;

    #[Assert\NotBlank(message: 'userProfile@pseudonymIsRequired')]
    #[Assert\Length(max: 25, maxMessage: 'userProfile@maxPseudonymLength')]
    public ?string $pseudonym = null;

    #[Assert\Email(message: 'common@incorrectEmail')]
    public ?string $email = null;

    protected function wrapper(): void
    {
        $this->addExpectKey('pseudonym');
        $this->addExpectKey('email');
        $this->addExpectKey('password');
        $this->addExpectKey('password_confirm', 'passwordConfirm');
    }
}