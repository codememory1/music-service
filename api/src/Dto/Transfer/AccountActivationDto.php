<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\User;
use App\Infrastucture\Dto\AbstractDataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

final class AccountActivationDto extends AbstractDataTransfer
{
    protected array $propertyNameToData = [
        'user' => 'email'
    ];

    #[Assert\NotBlank(message: 'user@failedToIdentify')]
    #[DtoConstraints\ToEntityConstraint('email')]
    public ?User $user = null;

    #[Assert\NotBlank(message: 'common@invalidCode')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $code = null;
}