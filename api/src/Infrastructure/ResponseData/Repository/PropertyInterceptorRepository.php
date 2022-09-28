<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;

final class PropertyInterceptorRepository
{
    public function __construct(
        public readonly ConstraintInterface $constraint,
        public readonly string $handler
    ) {
    }
}