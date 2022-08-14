<?php

namespace App\Dto\Interfaces;

interface DataTransferValueInterceptorConstraintHandlerInterface
{
    public function handle(DataTransferConstraintInterface $constraint, mixed $value): mixed;
}