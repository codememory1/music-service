<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Dto\Interfaces\ServiceAuthorizationDtoInterface;
use App\Infrastructure\Dto\AbstractDataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

final class GoogleAuthDto extends AbstractDataTransfer implements ServiceAuthorizationDtoInterface
{
    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'serviceAuth@authorizationCodeIsRequired')
    ])]
    public ?string $code = null;
}