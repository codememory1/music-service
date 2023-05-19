<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Dto\Transfer\Traits\SetPasswordTrait;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

final class RegistrationDto extends DataTransfer
{
    use SetPasswordTrait;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'userProfile@pseudonymIsRequired'),
        new Assert\Length(max: 25, maxMessage: 'userProfile@maxPseudonymLength')
    ])]
    public ?string $pseudonym = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'common@incorrectEmail'),
        new Assert\Email(message: 'common@incorrectEmail')
    ])]
    public ?string $email = null;
}