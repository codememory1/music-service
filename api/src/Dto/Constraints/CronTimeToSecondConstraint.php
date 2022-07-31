<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;

/**
 * Class CronTimeToSecondConstraint.
 *
 * @package App\Dto\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class CronTimeToSecondConstraint implements DataTransferConstraintInterface
{
    public function getHandler(): ?string
    {
        return CronTimeToSecondConstraintHandler::class;
    }
}