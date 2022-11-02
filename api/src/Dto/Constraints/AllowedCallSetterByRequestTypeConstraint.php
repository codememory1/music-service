<?php

namespace App\Dto\Constraints;

use App\Infrastucture\Dto\Interfaces\DataTransferConstraintInterface;
use App\Enum\RequestTypeEnum;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class AllowedCallSetterByRequestTypeConstraint implements DataTransferConstraintInterface
{
    public function __construct(
        public readonly RequestTypeEnum $requestType
    ) {}

    public function getHandler(): ?string
    {
        return AllowedCallSetterByRequestTypeConstraintHandler::class;
    }
}