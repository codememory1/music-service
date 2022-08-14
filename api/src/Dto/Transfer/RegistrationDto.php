<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Dto\Traits\SetPasswordTrait;
use Symfony\Component\Validator\Constraints as Assert;

final class RegistrationDto extends AbstractDataTransfer
{
    use SetPasswordTrait;

    #[Assert\NotBlank(message: 'userProfile@pseudonymIsRequired')]
    #[Assert\Length(max: 25, maxMessage: 'userProfile@maxPseudonymLength')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $pseudonym = null;

    #[Assert\NotBlank(message: 'common@incorrectEmail')]
    #[Assert\Email(message: 'common@incorrectEmail')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $email = null;
}