<?php

namespace App\Infrastructure\Dto\Interfaces;

interface DataTransferCallSetterConstraintHandlerInterface
{
    public function handle(DataTransferConstraintInterface $constraint): bool;
}