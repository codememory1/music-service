<?php

namespace App\Dto\Interfaces;

interface DataTransferCallSetterConstraintHandlerInterface
{
    public function handle(DataTransferConstraintInterface $constraint): bool;
}