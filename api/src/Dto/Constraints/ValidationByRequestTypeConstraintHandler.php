<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\AbstractDataTransferConstraintHandler;
use App\Infrastructure\Dto\DataTransferValidationRepository;
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
    public function handle(DataTransferConstraintInterface $constraint, DataTransferValidationRepository $validationRepository): void
    {
        if ($this->request->getRequestType() === $constraint->requestType->value) {
            $validationRepository->addInput($this->getPropertyName(), $this->getPropertyValue());
            $validationRepository->addConstraints($this->getPropertyName(), $constraint->constraints);
        }
    }
}