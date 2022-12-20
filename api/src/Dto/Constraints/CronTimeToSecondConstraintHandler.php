<?php

namespace App\Dto\Constraints;

use App\Infrastructure\CronTime\Parser;
use App\Infrastructure\Dto\AbstractDataTransferConstraintHandler;
use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use App\Infrastructure\Dto\Interfaces\DataTransferValueInterceptorConstraintHandlerInterface;

final class CronTimeToSecondConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferValueInterceptorConstraintHandlerInterface
{
    public function __construct(
        private readonly Parser $cronTimeParser
    ) {
    }

    /**
     * @param CronTimeToSecondConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint, mixed $value): int
    {
        return $this->cronTimeParser->setTime($value)->toSecond();
    }
}