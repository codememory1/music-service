<?php

namespace App\Validator\Constraints;

use App\Infrastructure\CronTime\Parser;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class CronTimeValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof CronTime) {
            throw new UnexpectedTypeException($constraint, CronTime::class);
        }

        $parserCronTime = new Parser();

        $parserCronTime->setTime($value);

        if (!$parserCronTime->isIncorrect()) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ formats }}', implode(', ', $parserCronTime->getFormats()))
                ->addViolation();
        }
    }
}