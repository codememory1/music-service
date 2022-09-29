<?php

namespace App\Infrastructure\ResponseData\Constraints\Value;

use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class CallbackResponseData implements ConstraintInterface
{
    public function __construct(
        public readonly string $namespaceResponseData,
        public readonly array $ignoreProperties = [],
        public readonly array $onlyProperties = []
    ) {
    }

    public function getHandler(): string
    {
        return CallbackResponseDataHandler::class;
    }
}