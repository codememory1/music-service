<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ToEntityConstraint implements DataTransferConstraintInterface
{
    public function __construct(
        public readonly string $byProperty
    ) {
    }

    public function getHandler(): ?string
    {
        return ToEntityConstraintHandler::class;
    }
}