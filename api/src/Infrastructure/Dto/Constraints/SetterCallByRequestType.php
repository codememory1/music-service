<?php

namespace App\Infrastructure\Dto\Constraints;

use App\Enum\RequestTypeEnum;
use Codememory\Dto\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class SetterCallByRequestType implements ConstraintInterface
{
    public function __construct(
        public readonly RequestTypeEnum $type,
        public readonly bool $useDefaultValue = false
    ) {
    }

    public function getHandler(): string
    {
        return SetterCallByRequestTypeHandler::class;
    }
}