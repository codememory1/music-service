<?php

namespace App\Dto\Constraints;

use App\Infrastucture\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ToEnumConstraint implements DataTransferConstraintInterface
{
    public function __construct(
        public readonly string $enum
    ) {}

    public function getHandler(): ?string
    {
        return ToEnumConstraintHandler::class;
    }
}