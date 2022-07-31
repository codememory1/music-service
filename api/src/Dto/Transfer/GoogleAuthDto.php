<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Dto\Interfaces\ServiceAuthorizationDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class GoogleAuthDto.
 *
 * @package App\Dto\Transfer
 *
 * @author  Codememory
 */
final class GoogleAuthDto extends AbstractDataTransfer implements ServiceAuthorizationDtoInterface
{
    #[Assert\NotBlank(message: 'serviceAuth@authorizationCodeIsRequired')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $code = null;
}