<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferConstraintInterface;
use App\Enum\RequestTypeEnum;
use Attribute;

/**
 * Class AllowedCallSetterByRequestTypeConstraint.
 *
 * @package App\Dto\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class AllowedCallSetterByRequestTypeConstraint implements DataTransferConstraintInterface
{
    public readonly RequestTypeEnum $requestType;

    public function __construct(RequestTypeEnum $requestType)
    {
        $this->requestType = $requestType;
    }

    public function getHandler(): ?string
    {
        return AllowedCallSetterByRequestTypeConstraintHandler::class;
    }
}