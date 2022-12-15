<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class AsPathConstraint implements DataTransferConstraintInterface
{
    public function __construct(
        public readonly array $assert = []
    ) {
    }

    public function getHandler(): ?string
    {
        return AsPathConstraintHandler::class;
    }
}