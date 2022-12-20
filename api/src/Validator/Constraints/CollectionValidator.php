<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class CollectionValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Collection) {
            throw new UnexpectedTypeException($constraint, Collection::class);
        }

        $object = $this->context->getObject();
        $collection = $object->{$constraint->methodName}();

        foreach ($collection as $propertyName => $constraints) {
            $propertyValue = $object->{$propertyName};

            $this->context->getValidator()
                ->inContext($this->context)
                ->atPath($propertyName)
                ->validate($propertyValue, $constraints);
        }
    }
}