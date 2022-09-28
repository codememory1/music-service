<?php

namespace App\Infrastructure\ResponseData\Constraints\Value;

use App\Infrastructure\ResponseData\Constraints\AbstractConstraintHandler;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintValueHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ResponseDataInterface;

final class CallbackHandler extends AbstractConstraintHandler implements ConstraintValueHandlerInterface
{
    /**
     * @param callable $constraint
     */
    public function handle(ConstraintInterface $constraint, ResponseDataInterface $responseData, mixed $value): mixed
    {
        $class = null === $constraint->class ? $responseData : new ($constraint->class)();

        return $class->{$constraint->methodName}($value);
    }
}