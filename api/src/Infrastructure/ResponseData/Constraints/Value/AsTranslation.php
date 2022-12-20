<?php

namespace App\Infrastructure\ResponseData\Constraints\Value;

use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class AsTranslation implements ConstraintInterface
{
    public function getHandler(): string
    {
        return AsTranslationHandler::class;
    }
}