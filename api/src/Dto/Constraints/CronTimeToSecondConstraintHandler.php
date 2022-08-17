<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferConstraintInterface;
use App\Dto\Interfaces\DataTransferValueInterceptorConstraintHandlerInterface;
use App\Service\ParseCronTimeService;

final class CronTimeToSecondConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferValueInterceptorConstraintHandlerInterface
{
    private ParseCronTimeService $parseCronTimeService;

    public function __construct(ParseCronTimeService $parseCronTimeService)
    {
        $this->parseCronTimeService = $parseCronTimeService;
    }

    /**
     * @param CronTimeToSecondConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint, mixed $value): int
    {
        return $this->parseCronTimeService->setTime($value)->toSecond();
    }
}