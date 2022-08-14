<?php

namespace App\ResponseData\Constraints;

use App\Enum\RequestTypeEnum;
use App\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class RequestType implements ConstraintInterface
{
    public readonly string $requestType;

    public function __construct(RequestTypeEnum $requestTypeEnum)
    {
        $this->requestType = $requestTypeEnum->value;
    }

    public function getHandler(): string
    {
        return RequestTypeHandler::class;
    }
}