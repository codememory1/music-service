<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;

/**
 * Class ToEnumConstraint.
 *
 * @package App\Dto\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class ToEnumConstraint implements DataTransferConstraintInterface
{
    public readonly string $enum;

    public function __construct(string $enum)
    {
        $this->enum = $enum;
    }

    public function getHandler(): ?string
    {
        return ToEnumConstraintHandler::class;
    }
}