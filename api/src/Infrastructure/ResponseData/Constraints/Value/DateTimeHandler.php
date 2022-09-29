<?php

namespace App\Infrastructure\ResponseData\Constraints\Value;

use App\Infrastructure\ResponseData\Constraints\AbstractConstraintHandler;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintValueHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ResponseDataInterface;

final class DateTimeHandler extends AbstractConstraintHandler implements ConstraintValueHandlerInterface
{
    /**
     * @param DateTime $constraint
     */
    public function handle(ConstraintInterface $constraint, ResponseDataInterface $responseData, mixed $value): mixed
    {
        return $value?->format($constraint->format);
    }
}