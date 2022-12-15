<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class CallbackValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Callback) {
            throw new UnexpectedTypeException($constraint, Callback::class);
        }

        $object = null !== $constraint->className ? new ($constraint->className)() : $this->context->getObject();

        $object->{$constraint->methodName}($this->context);
    }
}