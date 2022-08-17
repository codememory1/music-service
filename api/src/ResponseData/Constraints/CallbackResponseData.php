<?php

namespace App\ResponseData\Constraints;

use App\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class CallbackResponseData implements ConstraintInterface
{
    public readonly string $namespaceResponseData;
    public readonly array $ignoreProperties;
    public readonly bool $asFirst;

    public function __construct(string $namespaceResponseData, bool $asFirst = false, array $ignoreProperties = [])
    {
        $this->namespaceResponseData = $namespaceResponseData;
        $this->asFirst = $asFirst;
        $this->ignoreProperties = $ignoreProperties;
    }

    public function getHandler(): string
    {
        return CallbackResponseDataHandler::class;
    }
}