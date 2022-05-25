<?php

namespace App\ResponseData\Constraints;

use App\ResponseData\Interfaces\ConstraintInterface;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Interfaces\ValueHandlerInterface;

/**
 * Class CallbackHandler.
 *
 * @package App\ResponseData\Constraints
 *
 * @author  Codememory
 */
class CallbackHandler implements ValueHandlerInterface
{
    /**
     * @inheritDoc
     *
     * @param callable|ConstraintInterface $constraint
     */
    public function handle(ConstraintInterface $constraint, ResponseDataInterface $responseData, mixed $value): mixed
    {
        $class = null === $constraint->class ? $responseData : new ($constraint->class)();

        return $class->{$constraint->methodName}($value);
    }
}