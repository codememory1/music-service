<?php

namespace App\ValidatorConstraints;

use App\Service\ParseCronTimeService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class CronTimeValidator
 *
 * @package App\ValidatorConstraints
 *
 * @author  Codememory
 */
class CronTimeValidator extends ConstraintValidator
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