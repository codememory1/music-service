<?php

namespace App\DTO\Open;

use Codememory\Dto\Constraints as DC;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

#[DC\ToType]
final class AuthorizationDTO extends DataTransfer
{
    #[DC\Validation([
        new Assert\NotBlank(message: 'field.is_required.email')
    ])]
    public ?string $email = null;

    #[DC\Validation([
        new Assert\NotBlank(message: 'field.is_required.password')
    ])]
    public ?string $password = null;
}