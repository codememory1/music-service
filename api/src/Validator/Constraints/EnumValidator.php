<?php

namespace App\Validator\Constraints;

use function defined;
use function is_array;
use function Symfony\Component\String\u;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

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

        if (is_array($value)) {
            foreach ($value as $item) {
                $this->validateValue((string) $item, $constraint);
            }
        } else {
            $this->validateValue((string) $value, $constraint);
        }
    }

    /**
     * @param Enum $constraint
     */
    private function validateValue(?string $value, Constraint $constraint): void
    {
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