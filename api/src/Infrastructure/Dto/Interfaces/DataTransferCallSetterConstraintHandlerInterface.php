<?php

namespace App\Infrastucture\Dto\Interfaces;

interface DataTransferCallSetterConstraintHandlerInterface
{
    public function handle(DataTransferConstraintInterface $constraint): bool;
}