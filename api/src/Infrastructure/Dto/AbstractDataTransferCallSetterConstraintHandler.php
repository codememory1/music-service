<?php

namespace App\Infrastructure\Dto;

use App\Infrastructure\Dto\Interfaces\DataTransferCallSetterConstraintHandlerInterface;

abstract class AbstractDataTransferCallSetterConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferCallSetterConstraintHandlerInterface
{
    private mixed $propertyValue = null;
    private ?DtoValidationRepository $validationRepository = null;

    public function getPropertyValue(): mixed
    {
        return $this->propertyValue;
    }

    public function setPropertyValue(mixed $value): DataTransferCallSetterConstraintHandlerInterface
    {
        $this->propertyValue = $value;

        return $this;
    }

    public function getValidationRepository(): ?DtoValidationRepository
    {
        return $this->validationRepository;
    }

    public function setValidationRepository(DtoValidationRepository $validationRepository): DataTransferCallSetterConstraintHandlerInterface
    {
        $this->validationRepository = $validationRepository;

        return $this;
    }
}