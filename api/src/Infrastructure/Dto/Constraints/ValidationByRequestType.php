<?php

namespace App\Infrastructure\Dto\Constraints;

use App\Enum\RequestTypeEnum;
use Attribute;
use Codememory\Dto\Interfaces\ConstraintInterface;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ValidationByRequestType implements ConstraintInterface
{
    /**
     * @param array<int, Constraint> $assert
     */
    public function __construct(
        public readonly RequestTypeEnum $type,
        public readonly array $assert
    ) {
    }

    public function getHandler(): string
    {
        return ValidationByRequestTypeHandler::class;
    }
}