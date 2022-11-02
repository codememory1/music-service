<?php

namespace App\Infrastucture\Dto\Interfaces;

interface DataTransferValueInterceptorConstraintHandlerInterface
{
    public function handle(DataTransferConstraintInterface $constraint, mixed $value): mixed;
}