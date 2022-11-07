<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\AbstractDataTransferConstraintHandler;
use App\Infrastructure\Dto\Interfaces\DataTransferCallSetterConstraintHandlerInterface;
use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use LogicException;

final class IgnoreCallSetterCallbackConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferCallSetterConstraintHandlerInterface
{
    /**
     * @param IgnoreCallSetterCallbackConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint): bool
    {
        if (false === method_exists($this->getDataTransfer(), $constraint->methodName)) {
            throw new LogicException(sprintf('Callback method %s not found in DTO %s', $constraint->methodName, $this->getDataTransfer()::class));
        }

        return $this->getDataTransfer()->{$constraint->methodName}($constraint, $this->getDataTransfer());
    }
}