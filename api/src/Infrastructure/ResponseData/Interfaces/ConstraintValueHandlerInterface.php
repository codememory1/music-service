<?php

namespace App\Infrastructure\ResponseData\Interfaces;

use App\ResponseData\Interfaces\ConstraintInterface;
use App\ResponseData\Interfaces\ResponseDataInterface;

interface ConstraintValueHandlerInterface extends ConstraintHandlerInterface
{
    public function handle(ConstraintInterface $constraint, ResponseDataInterface $responseData, mixed $value): mixed;
}