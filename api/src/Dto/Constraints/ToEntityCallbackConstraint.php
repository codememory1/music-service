<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;

/**
 * Class ToEntityCallbackConstraint.
 *
 * @package App\Dto\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class ToEntityCallbackConstraint implements DataTransferConstraintInterface
{
    public readonly string $methodName;

    public function __construct(string $methodName)
    {
        $this->methodName = $methodName;
    }

    public function getHandler(): ?string
    {
        return ToEntityCallbackConstraintHandler::class;
    }
}