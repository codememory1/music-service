<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

final class RefreshTokenDto extends DataTransfer
{
    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'common@refreshTokenIsRequired')
    ])]
    public ?string $refreshToken = null;
}