<?php

namespace App\Collection;

use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use ReflectionAttribute;

final class DtoConstraintCollection
{
    public function __construct(
        public readonly DataTransferConstraintInterface $constraint,
        public readonly ReflectionAttribute $reflectionAttribute
    ) {
    }
}