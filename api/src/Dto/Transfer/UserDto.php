<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Infrastructure\Dto\AbstractDataTransfer;

final class UserDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    public ?string $ip = null;
}