<?php

namespace App\Infrastructure\Dto;

use App\Infrastructure\Dto\Interfaces\DataTransferCallSetterConstraintHandlerInterface;

abstract class AbstractDataTransferCallSetterConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferCallSetterConstraintHandlerInterface
{
    private ?DataTransferValidationRepository $validationRepository = null;

    public function getValidationRepository(): ?DataTransferValidationRepository
    {
        return $this->validationRepository;
    }

    public function setValidationRepository(DataTransferValidationRepository $validationRepository): DataTransferCallSetterConstraintHandlerInterface
    {
        $this->validationRepository = $validationRepository;

        return $this;
    }
}