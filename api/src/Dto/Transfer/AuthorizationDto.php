<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

final class AuthorizationDto extends DataTransfer
{
    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'common@incorrectEmail')
    ])]
    public ?string $email = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'common@passwordIsRequired')
    ])]
    public ?string $password = null;
}