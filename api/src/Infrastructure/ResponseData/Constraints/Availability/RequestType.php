<?php

namespace App\Infrastructure\ResponseData\Constraints\Availability;

use App\Enum\RequestTypeEnum;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class RequestType implements ConstraintInterface
{
    public function __construct(
        public readonly RequestTypeEnum $requestType
    ) {
    }

    public function getHandler(): string
    {
        return RequestTypeHandler::class;
    }
}