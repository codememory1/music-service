<?php

namespace App\Dto\Constraints;

use App\Enum\RequestTypeEnum;
use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ValidationByRequestTypeConstraint implements DataTransferConstraintInterface
{
    /**
     * @param array<int, Constraint> $constraints
     */
    public function __construct(
        public readonly RequestTypeEnum $requestType,
        public readonly array $constraints
    ) {
    }

    public function getHandler(): ?string
    {
        return ValidationByRequestTypeConstraintHandler::class;
    }
}