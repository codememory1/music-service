<?php

namespace App\Validator\Constraints;

use function defined;
use function Symfony\Component\String\u;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class EnumValidator.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
final class EnumValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Enum) {
            throw new UnexpectedTypeException($constraint, Enum::class);
        }

        if (empty($value) && $constraint->allowedNullable) {
            return;
        }

        $caseName = u($value)->upper();
        $existCase = defined("{$constraint->enum}::${caseName}");

        if (false === class_exists($constraint->enum) || false === $existCase) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ case }}', $caseName)
                ->setParameter('{{ enum }}', $constraint->enum)
                ->addViolation();
        }
    }
}