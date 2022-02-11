<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class BetweenValidator
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
final class BetweenValidator extends ConstraintValidator
{

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint)
    {

        if (!$constraint instanceof Between) {
            throw new UnexpectedTypeException($constraint, Between::class);
        }

        if ($value !== $this->context->getObject()->{$constraint->with}()) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ current }}', $this->context->getPropertyName())
                ->setParameter('{{ with }}', $constraint->with)
                ->addViolation();
        }

    }

}