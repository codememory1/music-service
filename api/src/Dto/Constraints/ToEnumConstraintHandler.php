<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferConstraintInterface;
use App\Dto\Interfaces\DataTransferValueInterceptorConstraintHandlerInterface;
use function constant;
use function defined;
use function Symfony\Component\String\u;

final class ToEnumConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferValueInterceptorConstraintHandlerInterface
{
    /**
     * @param ToEnumConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint, mixed $value): mixed
    {
        $caseName = u($value)->upper();
        $existCase = defined("{$constraint->enum}::${caseName}");

        if (false === class_exists($constraint->enum) || false === $existCase) {
            return null;
        }

        return constant("{$constraint->enum}::${caseName}");
    }
}