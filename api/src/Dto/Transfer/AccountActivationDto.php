<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Entity\User;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

final class AccountActivationDto extends DataTransfer
{
    #[DC\ToEntity(byKey: 'email')]
    #[DC\Validation([
        new Assert\NotBlank(message: 'user@failedToIdentify')
    ])]
    public ?User $email = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'common@invalidCode')
    ])]
    public ?string $code = null;
}