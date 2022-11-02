<?php

namespace App\Dto\Constraints;

use App\Infrastucture\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ToTypeConstraint implements DataTransferConstraintInterface
{
    public function __construct(
        public readonly ?string $type = null
    ) {
    }

    public function getHandler(): ?string
    {
        return ToTypeConstraintHandler::class;
    }
}