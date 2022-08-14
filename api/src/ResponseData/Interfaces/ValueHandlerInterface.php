<?php

namespace App\ResponseData\Interfaces;

interface ValueHandlerInterface
{
    public function handle(ConstraintInterface $constraint, ResponseDataInterface $responseData, mixed $value): mixed;
}