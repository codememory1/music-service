<?php

namespace App\ResponseData\Constraints;

use App\Enum\RequestTypeEnum;
use App\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

/**
 * Class RequestType.
 *
 * @package App\ResponseData\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class RequestType implements ConstraintInterface
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