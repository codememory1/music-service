<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class IgnoreCallSetterCallbackConstraint implements DataTransferConstraintInterface
{
    public function __construct(
        public readonly string $methodName
    ) {
    }

    public function getHandler(): ?string
    {
        return IgnoreCallSetterCallbackConstraintHandler::class;
    }
}