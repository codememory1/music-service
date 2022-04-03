<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class QuantityByDelimiterValidator.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class QuantityByDelimiterValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof QuantityByDelimiter) {
            throw new UnexpectedTypeException($constraint, QuantityByDelimiter::class);
        }

        $propertyName = $this->context->getPropertyName();

        $values = explode($constraint->delimiter, $value);

        if (count($values) < $constraint->min) {
            $this->context
                ->buildViolation($constraint->minMessage)
                ->setParameter('{{ property }}', $propertyName)
                ->setParameter('{{ min }}', $constraint->min)
                ->addViolation();

            return;
        }

        if (null !== $constraint->max && count($values) > $constraint->max) {
            $this->context
                ->buildViolation($constraint->maxMessage)
                ->setParameter('{{ property }}', $propertyName)
                ->setParameter('{{ max }}', $constraint->max)
                ->addViolation();
        }
    }
}