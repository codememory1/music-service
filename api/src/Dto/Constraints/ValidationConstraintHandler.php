<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\AbstractDataTransferConstraintHandler;
use App\Infrastructure\Dto\DataTransferValidationRepository;
use App\Infrastructure\Dto\Interfaces\DataTransferAssertConstraintHandlerInterface;
use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;

final class ValidationConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferAssertConstraintHandlerInterface
{
    /**
     * @param ValidationConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint, DataTransferValidationRepository $validationRepository): void
    {
        $validationRepository->addInput($this->getPropertyName(), $this->getPropertyValue());
        $validationRepository->addConstraints($this->getPropertyName(), $constraint->constraints);
    }
}