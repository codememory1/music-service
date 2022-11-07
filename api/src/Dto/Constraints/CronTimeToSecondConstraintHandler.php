<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\AbstractDataTransferConstraintHandler;
use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use App\Infrastructure\Dto\Interfaces\DataTransferValueInterceptorConstraintHandlerInterface;
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