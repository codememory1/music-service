<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Dto\Transfer\Traits\SetPasswordTrait;
use App\Infrastructure\Dto\AbstractDataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

final class RegistrationDto extends AbstractDataTransfer
{
    use SetPasswordTrait;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'userProfile@pseudonymIsRequired'),
        new Assert\Length(max: 25, maxMessage: 'userProfile@maxPseudonymLength')
    ])]
    public ?string $pseudonym = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'common@incorrectEmail'),
        new Assert\Email(message: 'common@incorrectEmail')
    ])]
    public ?string $email = null;
}