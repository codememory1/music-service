<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class IgnoreCallSetterConstraint implements DataTransferConstraintInterface
{
    public function getHandler(): ?string
    {
        return IgnoreCallSetterConstraintHandler::class;
    }
}