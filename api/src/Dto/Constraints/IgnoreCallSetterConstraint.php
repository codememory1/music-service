<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;

/**
 * Class IgnoreCallSetterConstraint.
 *
 * @package App\Dto\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class IgnoreCallSetterConstraint implements DataTransferConstraintInterface
{
    public function getHandler(): ?string
    {
        return IgnoreCallSetterConstraintHandler::class;
    }
}