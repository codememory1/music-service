<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\AbstractDataTransferConstraintHandler;
use App\Infrastructure\Dto\Interfaces\DataTransferCallSetterConstraintHandlerInterface;
use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;

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