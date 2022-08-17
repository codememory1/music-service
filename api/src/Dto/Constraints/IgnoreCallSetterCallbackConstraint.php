<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class IgnoreCallSetterCallbackConstraint implements DataTransferConstraintInterface
{
    public readonly string $methodName;

    public function __construct(string $methodName)
    {
        $this->methodName = $methodName;
    }

    public function getHandler(): ?string
    {
        return IgnoreCallSetterCallbackConstraintHandler::class;
    }
}