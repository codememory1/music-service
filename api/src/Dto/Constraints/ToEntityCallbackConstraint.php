<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ToEntityCallbackConstraint implements DataTransferConstraintInterface
{
    public function __construct(
        public readonly string $methodName
    ) {
    }

    public function getHandler(): ?string
    {
        return ToEntityCallbackConstraintHandler::class;
    }
}