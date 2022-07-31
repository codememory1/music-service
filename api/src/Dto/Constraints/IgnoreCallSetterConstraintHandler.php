<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferCallSetterConstraintHandlerInterface;
use App\Dto\Interfaces\DataTransferConstraintInterface;

/**
 * Class IgnoreCallSetterConstraintHandler.
 *
 * @package App\Dto\Constraints
 *
 * @author  Codememory
 */
final class IgnoreCallSetterConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferCallSetterConstraintHandlerInterface
{
    /**
     * @param IgnoreCallSetterConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint): bool
    {
        return false;
    }
}