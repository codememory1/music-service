<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class ArrayValuesValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ArrayValues) {
            throw new UnexpectedTypeException($constraint, ArrayValues::class);
        }

        $propertyName = $this->context->getPropertyName();

        if (count($value) < $constraint->min) {
            $this->context
                ->buildViolation($constraint->minMessage)
                ->setParameter('{{ property }}', $propertyName)
                ->setParameter('{{ min }}', $constraint->min)
                ->addViolation();

            return;
        }

        if (null !== $constraint->max && count($value) > $constraint->max) {
            $this->context
                ->buildViolation($constraint->maxMessage)
                ->setParameter('{{ property }}', $propertyName)
                ->setParameter('{{ max }}', $constraint->max)
                ->addViolation();
        }
    }
}