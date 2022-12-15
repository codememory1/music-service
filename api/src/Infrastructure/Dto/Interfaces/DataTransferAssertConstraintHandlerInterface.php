<?php

namespace App\Infrastructure\Dto\Interfaces;

use App\Infrastructure\Dto\DataTransferValidationRepository;

interface DataTransferAssertConstraintHandlerInterface
{
    public function handle(DataTransferConstraintInterface $constraint, DataTransferValidationRepository $validationRepository): void;
}