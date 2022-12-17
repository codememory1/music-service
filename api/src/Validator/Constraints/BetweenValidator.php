<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class BetweenValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Between) {
            throw new UnexpectedTypeException($constraint, Between::class);
        }

        $object = $this->context->getObject();
        $propertyOrMethod = $constraint->with;
        $asProperty = $constraint->property;
        $withValue = $asProperty ? $object->$propertyOrMethod : $object->$propertyOrMethod();

        if ($value !== $withValue) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ current }}', $this->context->getPropertyName() ?: $this->context->getPropertyPath())
                ->setParameter('{{ with }}', $constraint->with)
                ->addViolation();
        }
    }
}