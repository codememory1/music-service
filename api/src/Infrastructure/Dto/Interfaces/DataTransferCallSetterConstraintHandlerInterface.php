<?php

namespace App\Infrastructure\Dto\Interfaces;

use App\Infrastructure\Dto\DataTransferValidationRepository;

interface DataTransferCallSetterConstraintHandlerInterface
{
    public function setValidationRepository(DataTransferValidationRepository $validationRepository): self;

    public function handle(DataTransferConstraintInterface $constraint): bool;
}