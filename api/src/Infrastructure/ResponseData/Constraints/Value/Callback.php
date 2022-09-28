<?php

namespace App\Infrastructure\ResponseData\Constraints\Value;

use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Callback implements ConstraintInterface
{
    public readonly string $methodName;
    public readonly ?string $class;

    public function __construct(string $methodName, ?string $class = null)
    {
        $this->methodName = $methodName;
        $this->class = $class;
    }

    public function getHandler(): string
    {
        return CallbackHandler::class;
    }
}