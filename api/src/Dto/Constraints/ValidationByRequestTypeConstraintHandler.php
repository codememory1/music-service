<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\AbstractDataTransferConstraintHandler;
use App\Infrastructure\Dto\Interfaces\DataTransferAssertConstraintHandlerInterface;
use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use App\Rest\Http\Request;

final class ValidationByRequestTypeConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferAssertConstraintHandlerInterface
{
    public function __construct(
        private readonly Request $request
    ) {
    }

    /**
     * @param ValidationByRequestTypeConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint): void
    {
        if ($this->request->getRequestType() === $constraint->requestType->value) {
            $this->getDataTransfer()->addValidateConstraints($this->getPropertyName(), $constraint->constraints);
        }
    }
}