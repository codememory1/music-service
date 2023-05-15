<?php

namespace App\Constraints\Assert;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class ComparisonBetweenValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ComparisonBetween) {
            throw new UnexpectedTypeException($constraint, ComparisonBetween::class);
        }

        if (($this->context->getObject()->{$constraint->withProperty} === $value) === $constraint->is) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}