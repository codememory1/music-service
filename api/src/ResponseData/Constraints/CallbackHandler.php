<?php

namespace App\ResponseData\Constraints;

use App\ResponseData\Interfaces\ConstraintInterface;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Interfaces\ValueHandlerInterface;

final class CallbackHandler implements ValueHandlerInterface
{
    /**
     * @param Callback $constraint
     */
    public function handle(ConstraintInterface $constraint, ResponseDataInterface $responseData, mixed $value): mixed
    {
        $class = null === $constraint->class ? $responseData : new ($constraint->class)();

        return $class->{$constraint->methodName}($value);
    }
}