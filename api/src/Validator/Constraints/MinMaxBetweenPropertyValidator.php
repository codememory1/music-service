<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class MinMaxBetweenPropertyValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof MinMaxBetweenProperty) {
            throw new UnexpectedTypeException($constraint, MinMaxBetweenProperty::class);
        }

        $object = $this->context->getObject();
        $valueFromProperty = $object->{$constraint->property};

        if ((false !== $constraint->max && $value > $valueFromProperty)
            || (false !== $constraint->min && $value < $valueFromProperty)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ currentProperty }}', $this->context->getPropertyName())
                ->setParameter('{{ withProperty }}', $constraint->property)
                ->addViolation();
        }
    }
}