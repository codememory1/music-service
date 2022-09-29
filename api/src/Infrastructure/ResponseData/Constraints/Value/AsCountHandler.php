<?php

namespace App\Infrastructure\ResponseData\Constraints\Value;

use App\Infrastructure\ResponseData\Constraints\AbstractConstraintHandler;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintValueHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ResponseDataInterface;
use Countable;
use function is_array;
use function is_string;

final class AsCountHandler extends AbstractConstraintHandler implements ConstraintValueHandlerInterface
{
    /**
     * @param AsCount $constraint
     */
    public function handle(ConstraintInterface $constraint, ResponseDataInterface $responseData, mixed $value): int
    {
        if (is_array($value)) {
            return count($value);
        }

        if ($value instanceof Countable) {
            return $value->count();
        }

        if (is_string($value)) {
            return mb_strlen($value);
        }

        return (int) $value;
    }
}