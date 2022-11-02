<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferCallSetterConstraintHandlerInterface;
use App\Infrastucture\Dto\Interfaces\DataTransferConstraintInterface;

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