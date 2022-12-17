<?php

namespace App\Infrastructure\Dto\Interfaces;

interface DataTransferAssertConstraintHandlerInterface
{
    public function handle(DataTransferConstraintInterface $constraint): void;
}