<?php

namespace App\Collection;

use App\Dto\Interfaces\DataTransferConstraintInterface;
use ReflectionAttribute;

final class DtoConstraintCollection
{
    public readonly DataTransferConstraintInterface $constraint;
    public readonly ReflectionAttribute $reflectionAttribute;

    public function __construct(DataTransferConstraintInterface $constraint, ReflectionAttribute $reflectionAttribute)
    {
        $this->constraint = $constraint;
        $this->reflectionAttribute = $reflectionAttribute;
    }
}