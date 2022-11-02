<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use Symfony\Component\Validator\Constraints as Assert;
use App\Infrastucture\Dto\AbstractDataTransfer;

final class AuthorizationDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'common@incorrectEmail')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $email = null;

    #[Assert\NotBlank(message: 'common@passwordIsRequired')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $password = null;
}