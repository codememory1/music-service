<?php

namespace App\Infrastructure\Dto\Interfaces;

use App\Infrastructure\Dto\DtoValidationRepository;

interface DataTransferCallSetterConstraintHandlerInterface
{
    public function setPropertyValue(mixed $value): self;

    public function setValidationRepository(DtoValidationRepository $validationRepository): self;

    public function handle(DataTransferConstraintInterface $constraint): bool;
}