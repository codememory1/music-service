<?php

namespace App\ResponseData\Constraints;

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
    /**
     * @var string
     */
    public readonly string $requestType;

    /**
     * @param string $requestType
     */
    public function __construct(string $requestType)
    {
        $this->requestType = $requestType;
    }

    /**
     * @inheritDoc
     */
    public function getHandler(): string
    {
        return RequestTypeHandler::class;
    }
}