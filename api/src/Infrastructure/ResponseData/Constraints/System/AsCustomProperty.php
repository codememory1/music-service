<?php

namespace App\Infrastructure\ResponseData\Constraints\System;

use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class AsCustomProperty implements ConstraintInterface
{
    public function getHandler(): string
    {
        return AsCustomPropertyHandler::class;
    }
}