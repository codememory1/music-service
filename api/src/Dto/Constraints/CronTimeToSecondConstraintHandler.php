<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferValueInterceptorConstraintHandlerInterface;
use App\Infrastucture\Dto\Interfaces\DataTransferConstraintInterface;
use App\Service\ParseCronTimeService;

final class CronTimeToSecondConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferValueInterceptorConstraintHandlerInterface
{
    public function __construct(
        private readonly ParseCronTimeService $parseCronTimeService
    ) {
    }

    /**
     * @param CronTimeToSecondConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint, mixed $value): int
    {
        return $this->parseCronTimeService->setTime($value)->toSecond();
    }
}