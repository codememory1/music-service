<?php

namespace App\DTO\Interceptors;

use App\DTO\Interfaces\ValueInterceptorInterface;
use App\Service\ParseCronTimeService;

/**
 * Class CronTimeAsSecondInterceptor.
 *
 * @package App\DTO\Interceptors
 *
 * @author  Codememory
 */
final class CronTimeAsSecondInterceptor implements ValueInterceptorInterface
{
    /**
     * @inheritDoc
     */
    public function handle(string $key, mixed $value): int
    {
        $cronTime = new ParseCronTimeService();

        return $cronTime->setTime($value)->toSecond();
    }
}