<?php

namespace App\Validator\Constraints;

use App\Service\ParseCronTimeService;
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

        $parserCronTimeService = new ParseCronTimeService();

        $parserCronTimeService->setTime($value);

        if (!$parserCronTimeService->isIncorrect()) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ formats }}', implode(', ', $parserCronTimeService->getFormats()))
                ->addViolation();
        }
    }
}