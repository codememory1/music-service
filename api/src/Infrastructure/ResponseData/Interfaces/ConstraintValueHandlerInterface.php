<?php

namespace App\Infrastructure\ResponseData\Interfaces;

interface ConstraintValueHandlerInterface extends ConstraintHandlerInterface
{
    public function handle(ConstraintInterface $constraint, ResponseDataInterface $responseData, mixed $value): mixed;
}