<?php

namespace App\Infrastructure\ResponseData\Constraints\Value;

use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class DateTime implements ConstraintInterface
{
    public function __construct(
        public readonly string $format = 'Y-m-d H:i:s'
    ) {
    }

    public function getHandler(): string
    {
        return DateTimeHandler::class;
    }
}