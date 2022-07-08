<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class ConditionValidator.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
final class ConditionValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Condition) {
            throw new UnexpectedTypeException($constraint, Condition::class);
        }

        $object = $this->context->getObject();
        $callbackName = $constraint->callbackCondition;

        if ($object->$callbackName($value)) {
            $this->context
                ->getValidator()
                ->inContext($this->context)
                ->validate($value, $constraint->constraints);
        }
    }
}