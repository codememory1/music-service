<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;

/**
 * Class ToEntityConstraint.
 *
 * @package App\Dto\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class ToEntityConstraint implements DataTransferConstraintInterface
{
    public readonly string $byProperty;

    public function __construct(string $byProperty)
    {
        $this->byProperty = $byProperty;
    }

    public function getHandler(): ?string
    {
        return ToEntityConstraintHandler::class;
    }
}