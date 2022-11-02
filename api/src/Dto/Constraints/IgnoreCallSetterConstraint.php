<?php

namespace App\Dto\Constraints;

use App\Infrastucture\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class IgnoreCallSetterConstraint implements DataTransferConstraintInterface
{
    public function getHandler(): ?string
    {
        return IgnoreCallSetterConstraintHandler::class;
    }
}