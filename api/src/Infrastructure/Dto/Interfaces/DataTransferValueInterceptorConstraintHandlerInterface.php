<?php

namespace App\Infrastructure\Dto\Interfaces;

interface DataTransferValueInterceptorConstraintHandlerInterface
{
    public function handle(DataTransferConstraintInterface $constraint, mixed $value): mixed;
}