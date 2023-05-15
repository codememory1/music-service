<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Dto\Interfaces\ServiceAuthorizationDtoInterface;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

final class GoogleAuthDto extends DataTransfer implements ServiceAuthorizationDtoInterface
{
    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'serviceAuth@authorizationCodeIsRequired')
    ])]
    public ?string $code = null;
}