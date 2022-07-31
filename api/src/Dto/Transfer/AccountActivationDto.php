<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AccountActivationDto.
 *
 * @package App\Dto\Transfer
 *
 * @author  Codememory
 */
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