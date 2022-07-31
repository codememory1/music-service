<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;

/**
 * Class UserDto.
 *
 * @package App\Dto\Transfer
 *
 * @author  Codememory
 */
final class UserDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    public ?string $ip = null;
}