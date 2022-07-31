<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RefreshTokenDto.
 *
 * @package App\Dto\Transfer
 *
 * @author  Codememory
 */
final class RefreshTokenDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'common@refreshTokenIsRequired')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $refreshToken = null;
}