<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ToTypeConstraint implements DataTransferConstraintInterface
{
    public readonly ?string $type;

    public function __construct(?string $type = null)
    {
        $this->type = $type;
    }

    public function getHandler(): ?string
    {
        return ToTypeConstraintHandler::class;
    }
}