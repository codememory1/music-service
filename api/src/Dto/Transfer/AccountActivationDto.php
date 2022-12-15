<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\User;
use App\Infrastructure\Dto\AbstractDataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

final class AccountActivationDto extends AbstractDataTransfer
{
    protected array $propertyNameToData = [
        'user' => 'email'
    ];

    #[DtoConstraints\ToEntityConstraint('email')]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'user@failedToIdentify')
    ])]
    public ?User $user = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'common@invalidCode')
    ])]
    public ?string $code = null;
}