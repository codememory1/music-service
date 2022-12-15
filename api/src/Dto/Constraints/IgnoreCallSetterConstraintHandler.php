<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\AbstractDataTransferCallSetterConstraintHandler;
use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;

final class IgnoreCallSetterConstraintHandler extends AbstractDataTransferCallSetterConstraintHandler
{
    /**
     * @param IgnoreCallSetterConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint): bool
    {
        return false;
    }
}