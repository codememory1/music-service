<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use Codememory\Dto\DataTransfer;

final class UserDto extends DataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    public ?string $ip = null;
}