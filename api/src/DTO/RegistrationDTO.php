<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AppAssert;

/**
 * Class RegistrationDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class RegistrationDTO extends AbstractDTO
{
    #[Assert\NotBlank(message: 'userProfile@pseudonymIsRequired')]
    #[Assert\Length(max: 25, maxMessage: 'userProfile@maxPseudonymLength')]
    public ?string $pseudonym = null;

    #[Assert\Email(message: 'common@incorrectEmail')]
    public ?string $email = null;

    #[Assert\NotBlank(message: 'common@passwordIsRequired')]
    #[Assert\Regex('/^[a-zA-Z0-9\-\_\%\@\.\&\+]+$/', message: 'registration@incorrectPassword')]
    #[Assert\Length(min: 8, minMessage: 'registration@minPasswordLength')]
    public ?string $password = null;

    #[AppAssert\Between('password', message: 'registration@invalidConfirmPassword')]
    public ?string $passwordConfirm = null;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->addExpectKey('pseudonym');
        $this->addExpectKey('email');
        $this->addExpectKey('password');
        $this->addExpectKey('password_confirm', 'passwordConfirm');
    }

}