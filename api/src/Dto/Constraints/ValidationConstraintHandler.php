<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\AbstractDataTransferConstraintHandler;
use App\Infrastructure\Dto\Interfaces\DataTransferAssertConstraintHandlerInterface;
use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;

final class ValidationConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferAssertConstraintHandlerInterface
{
    /**
     * @param ValidationConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint): void
    {
        $this->getDataTransfer()->addValidateConstraints($this->getPropertyName(), $constraint->constraints);
    }
}